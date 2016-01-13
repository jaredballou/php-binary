<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package	 php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary\Field;
use Binary\Field\Property\Property;
use Binary\DataSet;
use Binary\Stream\StreamInterface;

/**
 * SignedInteger
 * Field.
 *
 * @since 1.0
 */
class SignedInteger extends AbstractSizedField
{
	/**
	 * {@inheritdoc}
	 */
	public function read(StreamInterface $stream, DataSet $result)
	{
		$data = $stream->read(4);

		if (strlen($data) < 2) {
			$data = str_pad($data, 2, "\0", STR_PAD_LEFT);
		}

		$unpacked = unpack('i', $data);
		$this->validate($unpacked[1]);
		$result->setValue($this->getName(), $unpacked[1]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function write(StreamInterface $stream, DataSet $result)
	{
		$dataSize = 4;

		$bytes = $result->getValue($this->name);

		for ($i = 0; $i < $dataSize; $i++) {
			$signedByte = (($bytes >> (($dataSize - (1 + $i)) * 8)) & 0xff);
			$stream->write(pack('C', intval($signedByte) & 0xff));
		}
	}
}

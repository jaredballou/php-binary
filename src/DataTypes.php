<?php
/**
 * php-binary
 * A PHP library for parsing structured binary streams
 *
 * @package	 php-binary
 * @author Damien Walsh <me@damow.net>
 */
namespace Binary;
use Binary\Field\Property\Property;
use Binary\DataSet;
use Binary\Stream\StreamInterface;

/**
 * Float
 * Field.
 *
 * @since 1.0
 */
class DataTypes
{
	public $datatypes = array(
		'Float'			=> array('f' => 4),
		'SignedChar'		=> array('c' => 1),
		'SignedInteger'		=> array('i' => 4),
		'SignedLong'		=> array('l' => 4),
		'SignedShort'		=> array('s' => 2),
		'UnsignedChar'		=> array('C' => 1),
		'UnsignedInteger'	=> array('I' => 4),
		'UnsignedLong'		=> array('L' => 4),
		'UnsignedShort'		=> array('S' => 2),
		'Vector'		=> array('fff' => 12),
	);
	public function GetFormat($type)
	{
		if (array_key_exists($type,$this->datatypes))
			return current(array_keys($this->datatypes[$type]));
	}
	public function GetSize($type)
	{
		if (array_key_exists($type,$this->datatypes))
			return current(array_values($this->datatypes[$type]));
	}
}
/*
a	NUL-padded string
A	SPACE-padded string
h	Hex string, low nibble first
H	Hex string, high nibble first
c	signed char
C	unsigned char
s	signed short (always 16 bit, machine byte order)
S	unsigned short (always 16 bit, machine byte order)
n	unsigned short (always 16 bit, big endian byte order)
v	unsigned short (always 16 bit, little endian byte order)
i	signed integer (machine dependent size and byte order)
I	unsigned integer (machine dependent size and byte order)
l	signed long (always 32 bit, machine byte order)
L	unsigned long (always 32 bit, machine byte order)
N	unsigned long (always 32 bit, big endian byte order)
V	unsigned long (always 32 bit, little endian byte order)
q	signed long long (always 64 bit, machine byte order)
Q	unsigned long long (always 64 bit, machine byte order)
J	unsigned long long (always 64 bit, big endian byte order)
P	unsigned long long (always 64 bit, little endian byte order)
f	float (machine dependent size and representation)
d	double (machine dependent size and representation)
x	NUL byte
X	Back up one byte
Z	NUL-padded string (new in PHP 5.5)
@	NUL-fill to absolute position
*/

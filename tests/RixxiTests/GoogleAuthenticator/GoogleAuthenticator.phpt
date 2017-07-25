<?php

declare(strict_types=1);

namespace RixxiTests\GoogleAuthenticator;

require_once __DIR__ . '/../bootstrap.php';

use Base32\Base32;
use Rixxi;
use Rixxi\GoogleAuthenticator\ConstantTimestampProvider;
use Rixxi\GoogleAuthenticator\GoogleAuthenticator;
use Tester\Assert;

test(function () {
	function rfc4226testVectors()
	{
		return [
			array('755224', '12345678901234567890', 0),
			array('287082', '12345678901234567890', 1),
			array('359152', '12345678901234567890', 2),
			array('969429', '12345678901234567890', 3),
			array('338314', '12345678901234567890', 4),
			array('254676', '12345678901234567890', 5),
			array('287922', '12345678901234567890', 6),
			array('162583', '12345678901234567890', 7),
			array('399871', '12345678901234567890', 8),
			array('520489', '12345678901234567890', 9),
		];
	}

	function testRfc4226testVectors($code, $secret, $count)
	{
		$period = 30;
		$authenticator = new GoogleAuthenticator(Base32::encode($secret), new ConstantTimestampProvider($count * $period), $period);
		Assert::same($code, $authenticator->computeCode());
	}

	foreach(rfc4226testVectors() as $data) {
		testRfc4226testVectors($data[0], $data[1], $data[2]);
	}
});

test(function () {

	function rfc6238testVectors()
	{
		return [
			array(/* 94 */'287082', '12345678901234567890', 59),
			array(/* 07 */'081804', '12345678901234567890', 1111111109),
			array(/* 14 */'050471', '12345678901234567890', 1111111111),
			array(/* 89 */'005924', '12345678901234567890', 1234567890),
			array(/* 69 */'279037', '12345678901234567890', 2000000000),
			array(/* 65 */'353130', '12345678901234567890', 20000000000),
		];
	}

	function testRfc6238testVectors($code, $secret, $timestamp)
	{
		$period = 30;
		$authenticator = new GoogleAuthenticator(Base32::encode($secret), new ConstantTimestampProvider($timestamp), $period);
		Assert::same($code, $authenticator->computeCode());
	}

	foreach(rfc6238testVectors() as $data) {
		testRfc6238testVectors($data[0], $data[1], $data[2]);
	}
});

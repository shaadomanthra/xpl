<?php

namespace PacketPrep\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AwsController extends Controller
{
	public function getAwsUrl($key){
		$s3 = \Storage::disk('s3');
		$client = $s3->getDriver()->getAdapter()->getClient();
		$expiry = "+240 minutes";

		$get = request()->get('get');
		if($get)
		$command = $client->getCommand('GetObjectAcl', [
		    'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
		    'ACL'=> 'public-read',
		    'Key'    => $key
		]);
		else
		$command = $client->getCommand('PutObject', [
		    'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
		    'ACL'=> 'public-read',
		    'Key'    => $key
		]);	



		$request = $client->createPresignedRequest($command, $expiry);

		return (string) $request->getUri();
	}
    

}

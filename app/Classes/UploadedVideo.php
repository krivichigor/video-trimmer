<?php

namespace App\Classes;

use Illuminate\Http\UploadedFile;

class UploadedVideo
{
	private $file;

	public function __construct(UploadedFile $file)
	{
		$this->file = $file;
	}

	public function moveFile($path = 'videos', $storage = 'public')
    {
    	$path = $this->file->store($path, $storage);
		return $path;
    }

    public function getDuration()
    {
    	$getID3 = new \getID3;
		$file = $getID3->analyze($this->file);

		return $file['playtime_seconds'];
    }
}
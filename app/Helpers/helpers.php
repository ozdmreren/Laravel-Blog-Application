<?php

function textclip($text){
	if(strlen($text)>100){
		return substr($text,0,100)."...";
	}else{
		return $text;
	}
}

function checkinBlog($blogId){ // burada kaldım. savedBlog olayını yapıyordum.
	$user = auth()->user();
	$blog = $user->savedBlogs->where('id',$blogId)->first();

	if($blog){
		return true;
	}else{
		return false;
	}
}
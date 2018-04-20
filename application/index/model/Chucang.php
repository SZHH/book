<?php
namespace app\index\model;
use think\Model;
class Chucang extends Model
{
	public function book()
	{
		return $this->belongsTo('book');
	}
	// public function record()
	// {
	// 	return $this->hasmany('record');
	// }
}
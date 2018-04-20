<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Book;
use app\index\model\Chucang;
use think\Request;
use think\Db;
use think\Session;

class BookController extends Controller
{
	public function index()
	{
		$data = Db::query("select book.id,bookname,author,count(*) as num from book join chucang on chucang.book_id = book.id where state = 0 group by book_id");
		$authority = Session::get('authority');
		$this->assign('authority',$authority);
		$username = Session::get('username');
		$this->assign('username',$username);
		$id = Session::get('id');
		$this->assign('id',$id);
		$this->assign('result',$data);
		return $this->fetch();
	}
	public function addbook()
	{
		$authority = Session::get('authority');
		$this->assign('authority',$authority);
		return $this->fetch();
	}
	public function addb(Request $request)
	{
		$book = new Book;
		$book->bookname = $request->post('bookname');
		$book->author = $request->post('author');
		if($book->save()){
			for($i = 0;$i < $request->post('number');$i++)
			{
				$chucang = new Chucang;
				$chucang->book_id = $book->id;
				$chucang->save();
			}
			return $this->fetch('success/absuccess');
		}else{
			return $book->getError();
		}
	}
	public function query(Request $request)
	{
		$data = Db::query("select book.id,bookname,author,count(*) as num from book join chucang on chucang.book_id = book.id where state = 0 and (bookname like '%".$request->post('query')."%' or author like '%".$request->post('query')."%') group by book_id");
		$authority = Session::get('authority');
		$this->assign('authority',$authority);
		$username = Session::get('username');
		$this->assign('username',$username);
		$id = Session::get('id');
		$this->assign('id',$id);
		$this->assign('result',$data);
		return $this->fetch();
	}
	public function deletebook($id)
	{
		$data = Book::where('id',$id)->find();
		$number = Chucang::where('book_id',$id)
		->where('state',0)
		->select();
		$authority = Session::get('authority');
		$this->assign('authority',$authority);
		$this->assign('result',$data);
		$this->assign('number',count($number));
		return $this->fetch();
	}
	public function deleteb(Request $request)
	{
		$data = Book::where('id',$request->post('id'))->find();
		for($i = 0;$i < $request->post('number');$i++){
			$single = Chucang::where('book_id',$request->post('id'))->find();
			$single->delete();
		}
		if($data->delete()){
			return $this->fetch('success/desuccess');
		}
	}
	public function editbook($id)
	{
		$data = Book::where('id',$id)->find();
		$authority = Session::get('authority');
		$this->assign('authority',$authority);
		$this->assign('result',$data);
		return $this->fetch();
	}
	public function editb(Request $request)
	{
		$book = Book::get($request->post('id'));
		if(	$book->bookname == $request->post('bookname')&&
			$book->author == $request->post('author'))
		{
			echo '未修改任何值！<br>';
			return '<a href="/book">返回</a>';
		}
		else
		{
			$book->bookname =$request->post('bookname');
			$book->author =$request->post('author');
			$book->save();
			return $this->fetch('success/edsuccess');
		}
	}
}

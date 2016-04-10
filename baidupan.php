<?php
require_once('workflows.php');
class App
{
	private static $_instance;
	private $_workflows;
	function __construct(){
		$this->_workflows = new workflows();
	}

	public function getInstance()
	{
		if (!self::$_instance instanceof self) {
			self::$_instance = new App();
		}
		return self::$_instance;
	}
	public function request($url)
	{
		return $this->_workflows->request($url);
	}

	public function filterDataList($data)
	{
		$dataList = array();
		preg_match_all('/(<a class="c-blocka" .*?>.*?<\/a>)/', $data, $dataList);
		return $dataList[1];
	}
	public function getData($keyword)
	{
		//后面可以在这里加入缓存机制
		//缓存路径$this->_workflows->cache();
		$url = 'http://wap.baidu.com/s?word=site%3Apan.baidu.com+' . $keyword;
		$data = $this->request($url);
		$num = 1;
		foreach( $this->filterDataList($data) as $item ) {
			preg_match('/<a .*? href="(.*?)" .*?>.*?<\/a>/',$item, $href);
			// preg_match('/<span class="date">(.*?)<\/span>/', $item, $time);
			preg_match('/文件大小:(.*?) /', $item, $size);
			// $time= " " . str_replace('&#160;', ' ', $time[1]);
			// $item = str_replace('&#160;', '', $title[2]);
			// $pos = strpos($item, '_免费高速下载');
			// $item = substr($item, 1, $pos-1);
            
            $title =preg_replace('/<.*?>/', '', $item);            

			// $desc = str_replace('&#160;', '', $desc[1]);
			// $desc = str_replace('<em>', '', $desc);
			// $desc = str_replace('</em>', '', $desc);
            $href = str_replace('&amp;', '====', $href[1]);

			$this->_workflows->result($num . '.' . time(), $href, $title, '文件大小:' . $size[1] . $href, 'icon.png');
			$num ++;
		}

		return $this->_workflows->toxml();
	}
	public function run($query)
	{
		return $this->getData($query);
	}
}
// echo App::getInstance()->run('三体');
?>

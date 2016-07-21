<?php
namespace John;

class Doe{

	public function write_message_to($name,$message = '<message text to put in>'){
		print "----------------------------\n";
		print str_pad("Hello $name,",28,' '). "|\n";
		$strs = explode("\n", $message);
		foreach ($strs as $key => $str) {
		print " " .str_pad(rtrim($str),27,' '). "|\n";
		}
		$self_name = str_replace('\\',' ',__CLASS__);
		print " " .str_pad("Regards,  ",27,' ', STR_PAD_LEFT). "|\n";
		print " " .str_pad($self_name,27,' ', STR_PAD_LEFT). "|\n";
		print "----------------------------\n\n\n";
	}
}
<?php
namespace John;

class Doe{

	public function write_message_to($name,$message = '<message text to put in>'){
		print "---------------------------\n";
		print "Hello $name,\n";
		print "$message\n";
		$self_name = str_replace('\\',' ',__CLASS__);
		print "Regards,\n".$self_name."\n";
		print "---------------------------\n\n\n";
	}
}

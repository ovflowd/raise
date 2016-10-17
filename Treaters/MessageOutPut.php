<?php

/*

If you need a http message use messageHttp(), this method get a http code and create a object message

for Couchbase message use messageCouch(), 

*/

namespace Raise\Treaters;

include_once '../Models/Message.php';



class MessageController {

	public function messageHttp($code) {
		
		$message_out;

		$myCluster = new CouchbaseCluster('127.0.0.1:8091');
		$myBucket = $myCluster->openBucket('metadata');

		try {//create a conction with database
			$query = CouchbaseN1qlQuery::fromString("SELECT * FROM `metadata` WHERE codHttp=\$p");
			$query->namedParams(array("p" => $code));

			$result = $myBucket->query($query);//save a result of search 

			foreach ($result->rows as $row) {
				$message_out=$row->metadata; //get a message object				
			}

			$message = new Message($message_out->codHttp, $message_out->codCouch, $message_out->message); //create a message model

		} catch (CouchbaseException $e) { //
		    printf("(code: %d)", $e->getCode());
		}

		return $message; //return a message object --> object(Message)#10 (3) { ["codeHttp"]=> string(3) "200" ["codeCouch"]=> string(2) "00" ["message"]=> string(10) "OK, Sucess" } 

	}

	public function messageCouch($code) {
		
		$message_out;

		$myCluster = new CouchbaseCluster('127.0.0.1:8091');
		$myBucket = $myCluster->openBucket('metadata');

		try {
			$query = CouchbaseN1qlQuery::fromString("SELECT * FROM `metadata` WHERE codCouch=\$p");
			$query->namedParams(array("p" => $code));

			$result = $myBucket->query($query);

			foreach ($result->rows as $row) {
				$message_out=$row->metadata;				
			}

			$message = new Message($message_out->codHttp, $message_out->codCouch, $message_out->message);

		} catch (CouchbaseException $e) {
		    printf("(code: %d)", $e->getCode());
		}

		return $Message;

	}

}
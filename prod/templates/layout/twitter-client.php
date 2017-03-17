<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
	<include src="../structure/_html-header.html"></include>
</head>

<body>
		<div id="wrapper">
      <include src="../structure/_header.html"></include>
      <div class="container">

      	<div class="row">
      		<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

      			<h1>Twitter Client</h1>

      			<div class="component twitter-client">

	      			<h2>Recent Tweets</h2>

								<?php
									//PHP Wrapper Script
									require_once('HTMLResources/php/TwitterAPIExchange.php');
									//require_once('HTMLResources/php/twitteroauth.php');

									/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
									$settings = array(
									'oauth_access_token' => "562280250-flnrCTecfEe1wW6f25Gqu7YdRW44KWoPuBiqbIPm",
									'oauth_access_token_secret' => "nigQVSUcCXwkj0pMxXTepYHnF0tyhTfw7WuL6cLkbrbt3",
									'consumer_key' => "Vq2vQzQlD1lew9sdC27T9Bc2l",
									'consumer_secret' => "pFv5VOYKtvZQm2Dx8Z1ulhQ9zgCkQ8fNerwz5wj1YYq9p8EXis"
									);

									//
									$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
									$requestMethod = "GET";
									if (isset($_GET['user']))  {$user = $_GET['user'];}  else {$user  = "lavenway";}
									if (isset($_GET['count'])) {$count = $_GET['count'];} else {$count = 5;}
									$getfield = "?screen_name=$user&count=$count";

									//Connect to the Twitter API
									$twitter = new TwitterAPIExchange($settings);

									//Do Stuff with the Data
									$string = json_decode($twitter->setGetfield($getfield)
									->buildOauth($url, $requestMethod)
									->performRequest(),$assoc = TRUE);

									if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}

									//Open list tag for twitter posts
									echo "<ul class='tweets'>";

									//Access the information about each tweet
									foreach($string as $items)
									    {
									    	//Repeat list tag for each tweet
									    	echo "<li>";
									    		//Show all json data

									    	echo "<ul class='tweet'>";

											    		//Get the post image and insert into html img tag
													    if (isset($items['entities']['media'])) {
													        foreach ($items['entities']['media'] as $media) {
													            $media_url = $media['media_url'];
													            echo "<li><img src='{$media_url}' width='100%' /></li>";
													        }
													    }

													    //echo json_encode($string, JSON_PRETTY_PRINT);
											    		echo "<li><span>"."Image: "."</span>".$items['entities']['media']."</li>";
											        echo "<li><span>"."Time and Date of Tweet: "."</span>".$items['created_at']."</li>";
											        echo "<li><span>"."Tweet: "."</span>". $items['text']."</li>";
											        echo "<li><span>"."Tweeted by: "."</span>". $items['user']['name']."</li>";
											        echo "<li><span>"."Screen name: "."</span>". $items['user']['screen_name']."</li>";
											        echo "<li><span>"."Followers: "."</span>". $items['user']['followers_count']."</li>";
											        echo "<li><span>"."Friends: "."</span>". $items['user']['friends_count']."</li>";

										      echo "</ul>";

									        //Close list tag for each tweet
									        echo "</li>";
									    }

									//End list tag for twitter posts
									echo "</ul>";

								?>

								<?php
									require_once('HTMLResources/php/twitteroauth.php');

									$messageError = "";
									$messageField = $_POST['message'];

									if ($_SERVER["REQUEST_METHOD"] == "POST") {
										if(empty($messageField)) {
											 $messageError = "Write Msg";
										   $messageField = $messageError;
										} else {
										    define("CONSUMER_KEY", "Vq2vQzQlD1lew9sdC27T9Bc2l");
											  define("CONSUMER_SECRET","pFv5VOYKtvZQm2Dx8Z1ulhQ9zgCkQ8fNerwz5wj1YYq9p8EXis");
											  define("OAUTH_TOKEN", "562280250-flnrCTecfEe1wW6f25Gqu7YdRW44KWoPuBiqbIPm");
											  define("OAUTH_SECRET", "nigQVSUcCXwkj0pMxXTepYHnF0tyhTfw7WuL6cLkbrbt3");

										    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
										    $content = $connection->get('account/verify_credentials');
										    $connection->post('statuses/update', array('status' => $messageField));
										    $messageField = "UPDATED Sucessfully";
										}
									}
							  ?>

							  <h2>Post a tweet</h2>

								<form method="post" id="formcomment">
									<fieldset>
								    <div id="errAll"></div>
								    <p><label for="name">Name</label><br/>
								    	<input type="text" name="name" id="name" value="" size="35" />
								    </p>
								    <p><label for="email">Email</label><br/>
								    	<input type="text" name="email" id="email" value="" size="35" />
								    </p>
								    <p><label for="url">URL</label><br/>
								    	<input type="text" name="url" id="url" value="" size="35" />
								    </p>
								    <p><label for="message">Message</label><br/>
								    	<textarea cols="54" rows="8" name="message" id="message"></textarea>
								    </p>
								    <p>
								    	<input type="submit" name="submitter" value="Submit Comment" />
								    	</p>
								    <input type="hidden" name="task" id="task" value="comment" />
									</fieldset>
								</form>

							</div>

      		</div>
      	</div>

      </div>
      <div class="push-sf"></div> <!-- for sticky footer -->
		</div><!-- .wrapper -->
		<include src="../structure/_footer.html"></include>
  </body>
</html>

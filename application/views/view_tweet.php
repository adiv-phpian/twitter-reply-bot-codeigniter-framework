<?php

//print_R("<pre>");print_r(json_decode($tweet->tweet_json));print_R("</pre>");return;

?>

<style>

table{
	width: 100%;
}

table td, th{
	padding: 5px;
}

table tr{
	padding-bottom: 1px solid #d0d0d0;
}

.border-btm{
	border-bottom: 1px solid #d0d0d0;
}

a{
	text-color: black;
	text-docoration: none;
}

</style>

<table>
<?php $tweet_o = $tweet; $tweet = json_decode($tweet->tweet_json); ?>

<thead>
	<tr >
		<th colspan="2">User</th><th> Counts </th><th>Location</th><th>User Since</th>
	</tr>
	<tr class="border-btm">
		<td style="padding-right:0px;"><img width="70px" src="<?=$tweet->user->profile_image_url?>" /></td>
		<td style="padding-left:3px;"><br><?=$tweet->user->name?>&nbsp;<br>@<?=$tweet->user->screen_name?></td>
		<td><?=$tweet->user->followers_count?> Followers<br><?=$tweet->user->friends_count?> Following <br><?=$tweet->user->statuses_count?> Tweets</th>
		<td><?=$tweet->user->location?></td><td><?=date("Y-m-d", strtotime($tweet->user->created_at))?></td></tr>

	</thead>

<tbody>

<tr>
<td colspan="7"><?=$tweet->text?></td>
</tr>

<tr>
	<td colspan="2">Posted at <?=date("Y-m-d H:i:s", strtotime($tweet->created_at))?>
	</td><td colspan="2"><?=$tweet->retweet_count?> Retweets</td><td colspan="2"><?=$tweet->favorite_count?> Favourites</td></tr>


<?php if(isset($tweet->entities->media) && count(($tweet->entities->media) > 0)){ ?>
<tr><th colspan="4">Photos</th></tr>
<tr class="border-btm"><th colspan="4">
 <?php foreach($tweet->entities->media as $link){  ?>
	 <img style="max-width:400px;max-height:400px;" src="<?=$link->media_url?>"><br>
 <?php } ?>
 </th>
</tr>
<?php } ?>

<?php if(count(($tweet->entities->urls) > 0)){ ?>
<tr><th colspan="4">Links</th></tr>
<tr class="border-btm"><th colspan="4">
 <?php foreach($tweet->entities->urls as $link){  ?>
	 <a target="__blank" href="<?=$link->expanded_url?>"><?=$link->display_url?></a><br>
 <?php } ?>

  <?php if(isset($tweet->user->entities->url)) {
		foreach($tweet->user->entities->url->urls as $link){ ?>
 	 <a target="__blank" href="<?=$link->expanded_url?>"><?=$link->display_url?></a><br>
  <?php }} ?>

	<?php foreach($tweet->user->entities->description->urls as $link){  ?>
 	 <a target="__blank" href="<?=$link->expanded_url?>"><?=$link->display_url?></a><br>
  <?php } ?>
</th></tr>
<?php } ?>

<?php if(count(($tweet->entities->hashtags) > 0)){ ?>
<tr><th colspan="4">Hashtags</th></tr>
<tr><th colspan="4">
 <?php foreach($tweet->entities->hashtags as $link){  ?>
	 #<?=$link->text?><br>
 <?php } ?>

</th></tr>
<?php } ?>

<?php if(count(($tweet->entities->user_mentions) > 0)){ ?>
<tr><th colspan="4">User Mentions</th></tr>
<tr class="border-btm"><th colspan="4">
 <?php foreach($tweet->entities->user_mentions as $link){  ?>
	 <a href="https://twitter.com/<?=$link->screen_name?>">@<?=$link->name?></a><br>
 <?php } ?>
</th></tr>

<?php } ?>

<tr>
	<td>
    <h3>Reply</h3>
  </td>
</tr>

<tr style="border: 1px solid #d0d0d0;">

<td colspan="7"><span style="font-weight: bold;"><?php if(isset($tweet_o->reply)) echo $tweet_o->reply; ?>&nbsp;</span></td>
</tr>


</tbody>

</table>

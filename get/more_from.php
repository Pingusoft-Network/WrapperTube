<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/config.inc.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/db_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/time_manip.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/user_helper.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/s/classes/video_helper.php"); ?>
<?php $__video_h = new video_helper($__db); ?>
<?php $__user_h = new user_helper($__db); ?>
<?php $__db_h = new db_helper(); ?>
<?php $__time_h = new time_helper(); ?>
<?php

if(!$__user_h->user_exists($_GET['n'])) { die('This user does not exist!'); }

$author_videos = $__video_h->fetch_user_videos($_GET['n']);
?>
											<ul id="watch-more-from" class="video-list">
												<?php
													$stmt = $__db->prepare("SELECT * FROM playlists where author = :a AND visibility = 'n' ORDER BY id DESC LIMIT 2");
													$stmt->bindParam(":a", $_GET['n']);
													$stmt->execute();
													while($_playlist = $stmt->fetch(PDO::FETCH_ASSOC)) {	
														$_playlist['videos'] = json_decode($_playlist['videos']);
								    $_playlist['count'] = count($_playlist['videos']);
                                                                    $_playlist['videos'] = array_slice($_playlist['videos'], 0, 4);
                                                                    $playlist_thumbs = [];
                                                                    foreach ($_playlist['videos'] as $vid) {
                                                                     if($__video_h->video_exists($vid)) {
                                                                     $video = $__video_h->fetch_video_rid($vid);
                                                                     $playlist_thumbs[] = $video['thumbnail'];
                                                                     } else {
                                                                      $playlist_thumbs[] = "default.jpg";
                                                                     }
                                                                    }
												?>
												<li class="video-list-item">
													<a href="/view_playlist?v=<?php echo $_playlist['rid']; ?>" class="related-playlist yt-uix-contextlink  yt-uix-sessionlink" data-sessionlink="ved=CAMQzhooAA%3D%3D&amp;ei=CKf4md_r7rMCFYMfRAodLGlRiA%3D%3D&amp;feature=list_other">
														<span class="ux-thumb-wrap">
															<span class="video-thumb ux-thumb yt-thumb-default-120 ">
																<span class="yt-thumb-clip">
																	<span class="yt-thumb-clip-inner">
																		<img src="/dynamic/thumbs/<?php echo $playlist_thumbs[0] ?? 'default.jpg'; ?>" alt="<?php echo htmlspecialchars($_playlist['title']); ?>" data-thumb="/dynamic/thumbs/<?php echo $playlist_thumbs[0] ?? 'default.jpg'; ?>" width="120">
																		<span class="vertical-align"></span>
																	</span>
																</span>
															</span>
															<span class="video-count">
																<strong><?php echo $_playlist['count']; ?></strong> videos </span>
														</span>
														<span class="thumb-row">
															<span class="video-thumb ux-thumb yt-thumb-default-40 ">
																<span class="yt-thumb-clip">
																	<span class="yt-thumb-clip-inner">
																		<img src="/dynamic/thumbs/<?php echo $playlist_thumbs[1] ?? 'default.jpg'; ?>" alt="Thumbnail" data-thumb="/dynamic/thumbs/<?php echo $playlist_thumbs[1] ?? 'default.jpg'; ?>" width="40">
																		<span class="vertical-align"></span>
																	</span>
																</span>
															</span>
															<span class="video-thumb ux-thumb yt-thumb-default-40 "> 
																<span class="yt-thumb-clip">
																	<span class="yt-thumb-clip-inner">
																		<img src="/dynamic/thumbs/<?php echo $playlist_thumbs[2] ?? 'default.jpg'; ?>" alt="Thumbnail" data-thumb="/dynamic/thumbs/<?php echo $playlist_thumbs[2] ?? 'default.jpg'; ?>" width="40">
																		<span class="vertical-align"></span>
																	</span>
																</span>
															</span>
															<span class="video-thumb ux-thumb yt-thumb-default-40 ">
																<span class="yt-thumb-clip">
																	<span class="yt-thumb-clip-inner">
																		<img src="/dynamic/thumbs/<?php echo $playlist_thumbs[3] ?? 'default.jpg'; ?>" alt="Thumbnail" data-thumb="/dynamic/thumbs/<?php echo $playlist_thumbs[3] ?? 'default.jpg'; ?>" width="40">
																		<span class="vertical-align"></span>
																	</span>
																</span>
															</span>
														</span>
														<span dir="ltr" class="title" title="<?php echo htmlspecialchars($_playlist['title']); ?>"><?php echo htmlspecialchars($_playlist['title']); ?></span>
													</a>
												</li>
												<?php } $stmt = null; ?>
												<div id="ppv-container" class="hid"></div>
												<?php
													$stmt = $__db->prepare("SELECT * FROM videos WHERE visibility = 'n' AND author = :a ORDER BY id DESC LIMIT 20");
													$stmt->bindParam(":a", $_GET['n']);
													$stmt->execute();
													while($video = $stmt->fetch(PDO::FETCH_ASSOC)) {	
														$video['age'] = $__time_h->time_elapsed_string($video['publish']);		
														$video['duration'] = $__time_h->timestamp($video['duration']);
														$video['views'] = $__video_h->fetch_video_views($video['rid']);
														$video['author'] = htmlspecialchars($video['author']);		
														$video['title'] = htmlspecialchars($video['title']);
														$video['description'] = $__video_h->shorten_description($video['description'], 50);
												?>
												<li class="video-list-item"><a href="/watch?v=<?php echo $video['rid']; ?>" class="related-video yt-uix-contextlink  yt-uix-sessionlink" data-sessionlink="ved=CAIQzRooAA%3D%3D&amp;<?php echo htmlspecialchars($_GET['n']); ?>&amp;feature=relmfu"><span class="ux-thumb-wrap contains-addto "><span class="video-thumb ux-thumb yt-thumb-default-120 "><span class="yt-thumb-clip"><span class="yt-thumb-clip-inner"><img src="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" alt="<?php echo $video['title']; ?>" onerror=";this.src='/dynamic/thumbs/default.jpg';" data-thumb="/dynamic/thumbs/<?php echo $video['thumbnail']; ?>" width="120"><span class="vertical-align"></span></span></span></span><span class="video-time"><?php echo $video['duration']; ?></span>
													<button onclick=";return false;" title="Watch Later" type="button" class="addto-button video-actions spf-nolink addto-watch-later-button yt-uix-button yt-uix-button-default yt-uix-button-short yt-uix-tooltip" data-button-menu-id="shared-addto-watch-later-login" data-video-ids="<?php echo $video['rid']; ?>" role="button"><span class="yt-uix-button-content">  <img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt="Watch Later">
													</span><img class="yt-uix-button-arrow" src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" alt=""></button>
													</span><span dir="ltr" class="title" title="<?php echo $video['title']; ?>"><?php echo $video['title']; ?></span><span class="stat attribution">by <span class="yt-user-name " dir="ltr"><?php echo htmlspecialchars($video['author']); ?></span></span><span class="stat view-count"><?php echo $video['views']; ?> views</span></a>
												</li>
												<?php } $stmt = null; ?>
											</ul>
											<div style="font-weight:bold;text-align:center;"><a href="/user/<?php echo htmlspecialchars($_GET['n']); ?>/videos">
See all <?php echo $author_videos; ?> videos
								</a></div>
											<ul id="watch-more-more-from" class="video-list hid">
											<p class="yt-spinner">
											<img src="//s.ytimg.com/yt/img/pixel-vfl3z5WfW.gif" class="yt-spinner-img" alt="">
											Loading...
											</p>
											</ul>

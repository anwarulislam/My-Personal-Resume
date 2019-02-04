<div class="liveParentDiv">
	  <span class="liveCLassOffline">এই মুহূর্তে লাইভ ক্লাস অনুষ্ঠিত হচ্ছেনা। পরবর্তী লাইভ ক্লাসের সময়সূচী নীচে দেয়া আছে।<br>নির্ধারিত সময়ে এই পেইজ রিফ্রেশ করুন।</span>
  <div class="innerRobiDiv">
	 <div class="robiShield"></div>
	 <span class="loadingVid">অনুগ্রহপূর্বক অপেক্ষার করুন...</span>
	 <div class="livevideo">
		<div class="yt-video-container">
		   <div id="player"></div>
		</div>
	 </div>
  </div>
  <div class="controlDiv">
	 <div id="livevideo_title"></div>
	 <button class="ctrlBtn" onclick="player.pauseVideo();" id="pauseBtn"><i class="fa fa-pause"></i></button> <button class="ctrlBtn" onclick="player.playVideo();" id="playBtn"><i class="fa fa-play"></i></button> <button class="ctrlBtn" onclick="goFs();" id="fscreenBtn"><i class="fa fa-arrows-alt"></i></button>
  </div>
</div>





		<script>


			var YtChannelId = 'UCecCgZ-MHJwUwRwFh3lu5rA';
			var Yt_API_KEY = 'AIzaSyCZlN_kACwBwPE__uL_7U5MyPgp-WWOWE8';
			var videoId;
			
			  function init() {
				gapi.client.setApiKey(Yt_API_KEY);
				gapi.client.load('youtube', 'v3').then(makeRequest);
			  }
			  
			  function makeRequest() {
				var request = gapi.client.youtube.search.list({
					part: 'snippet',
					channelId: YtChannelId,
					playerVars: { 'autoplay': 1, 'controls': 0, 'autohide':1, },
					maxResults: 1,
					type: 'video',
					eventType: 'live'
					
				});
				
				request.then(function(response) {
				  processResult(response);
				}, function(reason) {
				  console.log('Error: ' + reason.result.error.message);
				});
				
			  }
			  
			  function processResult(result){
				
				console.log(result);
				
				var json = JSON.parse(result.body);
				var rand = Math.floor((Math.random() * 5) + 1);
//var ytIDs = [ "A9qQGy_AoRg", "fvWx1BbcvS4", "0lo2-WxUHSY", "pXhXEKL9WIs", "ZgW420-WdO0", "z9ofcxVeNyw&t=4s" ];
				if(json.pageInfo.totalResults === 0){
    				videoId = 'JDX0b1ayzSg'; //ytIDs[rand];
    				createIframe();   
    				jQuery('.liveCLassOffline').css('display','block');
    				jQuery('#fscreenBtn').css('display','none');
				} 
				
				else {
				videoId = json.items[0].id.videoId;
				createIframe();    
				}
				
			  }
			  
			  function createIframe(){
			  
			  var tag = document.createElement('script');
			  tag.src = "https://www.youtube.com/iframe_api";
			  var firstScriptTag = document.getElementsByTagName('script')[0];
			  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
			  }
			  
			  var player;
			  function onYouTubeIframeAPIReady() {
				player = new YT.Player('player', {
				height: '720',
				width: '1280',
				showinfo: '0',
				modestbranding: '1',
				videoId: videoId,
				  events: {
					'onReady': onPlayerReady,
				  }
				});

			  }
		  
			  function onPlayerReady(event) {
				event.target.playVideo();
				var vData=player.getVideoData();
				jQuery("#livevideo_title").html(vData["title"]);
				/*var chatId="https://www.youtube.com/live_chat?v="+ vData["video_id"]+ "&embed_domain=10minuteschool.com"; 
				jQuery('#livechat').attr('src', chatId);*/
			  }
			  

  </script>
  <script src="https://apis.google.com/js/client.js?onload=init"></script> 

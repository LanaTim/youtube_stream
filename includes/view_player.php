<?php

function register_youtube_embed_plugin_scripts()
{
    wp_register_script("youtube-embed-custom-js", plugins_url("youtube-embed-custom/js/scripts.js"));
    wp_enqueue_script("youtube-embed-custom-js");

}
add_action("wp_enqueue_scripts", "register_youtube_embed_plugin_scripts");

function register_youtube_embed_plugin_styles()
{
    wp_register_style("youtube-embed-custom-css", plugins_url("youtube-embed-custom/css/custom.css"));
    wp_enqueue_style("youtube-embed-custom-css");
}
add_action("wp_enqueue_scripts", "register_youtube_embed_plugin_styles");

function getYoutubeListData($list_id, $strim_video_id, $default_video_id){

    $optionsPageSize = 15;
    $default_video = '';
    $default_video_thumb_url = '';
    $default_video_title_url = '';

    if(get_option('ops_channel_id_youtube') && get_option('ops_api_key_youtube')){

        $apiLive = 'https://www.googleapis.com/youtube/v3/search?part=snippet&channelId='.get_option('ops_channel_id_youtube').'&type=video&eventType=live&key='. get_option('ops_api_key_youtube');
        $apiLiveResult = wp_remote_get($apiLive);

        $jsonLiveResult = json_decode($apiLiveResult['body']);

        if (isset($jsonLiveResult->error))
        {
            if (isset($jsonLiveResult->error->message))
            {

                $error_message = '<div>Sorry, there was a YouTube API error: <em>'.htmlspecialchars(strip_tags($jsonLiveResult->error->message)).'</em>' .'</div>';
                return $error_message;
            }
        }

        if (isset($jsonLiveResult->items) && $jsonLiveResult->items != null && is_array($jsonLiveResult->items))
        {
            $default_video = $jsonLiveResult->items[0]->id->videoId;
            $default_video_thumb_url = $jsonLiveResult->items[0]->snippet->thumbnails->default->url;
            $default_video_title_url = $jsonLiveResult->items[0]->snippet->title;
        }
    }

    $apiEndpoint = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,status&playlistId=' . $list_id
    . '&maxResults=' . $optionsPageSize
    . '&key=' .  get_option('ops_api_key_youtube');
    $apiResult = wp_remote_get($apiEndpoint);
    $jsonResult = json_decode($apiResult['body']);

    if (isset($jsonResult->error))
    {
        if (isset($jsonResult->error->message))
        {

            $error_message = '<div>Sorry, there was a YouTube API error: <em>'.htmlspecialchars(strip_tags($jsonResult->error->message)).'</em>' .'</div>';
            return $error_message;
        }
    }

    if (isset($jsonResult->items) && $jsonResult->items != null && is_array($jsonResult->items))
    {
        if(!$default_video){
            if ($default_video_id){
                $default_video = $default_video_id;
            } else {
                $default_video = $jsonResult->items[0]->snippet->resourceId->videoId;
            }
        }

         $code .= '<div class="col-xs-12 full-video">
                    <iframe id="top-youtube-video" 
                            src="http://www.youtube.com/embed/' .$default_video. '"
                            frameborder="0" allowfullscreen></iframe>
                    <div class="playlist-toggle" onclick="togglePlaylist()">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </div>
                    <div id="playlist">
                        <div class="header-playlist">
                            <span>PLAYLIST</span>
                            <a href="#" onclick="togglePlaylist()"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </div>
                        <div class="content-playlist">';

                        if($default_video && $default_video_title_url && $default_video_thumb_url){
                            $code .= '<div class="playlist-video" onclick="toggleVideo(this)" data-videoid="'.$default_video.'">
                                <div class="video" style="background-image: url('.$default_video_thumb_url.'); background-size: 85px 50px;">
                                </div>
                                <div class="video-review">
                                    <h4>'.$default_video_title_url.'</h4>
                                </div>
                            </div>';
                        }


                        foreach ($jsonResult->items as $item)
                        {
                            $code .= '<div class="playlist-video" onclick="toggleVideo(this)" data-videoid="'.$item->snippet->resourceId->videoId.'">
                                    <div class="video" style="background-image: url('.$item->snippet->thumbnails->default->url.'); background-size: 85px 50px;">
                                    </div>
                                    <div class="video-review">
                                        <h4>'.$item->snippet->title.'</h4>
                                    </div>
                                </div>';
                        }

         $code .= ' </div></div></div>';
    }
    return $code;
}

function youtube_embed_shortcode( $atts )
{
    extract( shortcode_atts( array(
        'list_id' => '',
        'strim_video_id' => '',
        'default_video_id' => ''
    ), $atts ) );

    return getYoutubeListData($list_id, $strim_video_id, $default_video_id);
}
add_shortcode('youtube_player', 'youtube_embed_shortcode');
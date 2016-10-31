window.addEventListener("load", function(){
    var v = document.getElementsByClassName("youtube-video");
    for (var n = 0; n < v.length; n++) {
        var p = document.createElement("div");
        p.innerHTML = '<img class="youtube-thumb" src="//i.ytimg.com/vi/' + v[n].dataset.id + '/hqdefault.jpg"><div class="play-button"></div>';
        p.onclick = youtube_video_clicked;
        v[n].appendChild(p);
    }
}, false);


function youtube_video_clicked() {
    var iframe = document.createElement("iframe");
    iframe.setAttribute("src", "//www.youtube.com/embed/" + this.parentNode.dataset.id + "?autoplay=1&autohide=2&border=0&wmode=opaque&enablejsapi=1&controls=0&showinfo=0");
    iframe.setAttribute("frameborder", "0");
    iframe.setAttribute("id", "youtube-iframe");
    this.parentNode.replaceChild(iframe, this);
}

function togglePlaylist() {
    console.log('123123123');
    document.body.classList.toggle('open-playlist');
}

function toggleVideo($this) {
    $top_video = document.getElementById('top-youtube-video').getAttribute('src')
    $nex_id = $this.getAttribute('data-videoid');
    document.getElementById('top-youtube-video').setAttribute('src', 'http://www.youtube.com/embed/'+$nex_id+'');
}

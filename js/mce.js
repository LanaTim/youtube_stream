(function() {
    tinymce.create("tinymce.plugins.youtube_button_plugin", {

        init : function(ed, url) {

            //add new button
            ed.addButton("youtube", {
                title : "Youtube Player",
                cmd : "youtube_command",
                image : "https://cdn3.iconfinder.com/data/icons/free-social-icons/67/youtube_square_color-32.png"
            });

            //button functionality.
            ed.addCommand("youtube_command", function() {
                var id = prompt("Please enter your list id");
                if (id != null)
                {
                    ed.execCommand("mceInsertContent", 0, '[youtube_player list_id="'+id+'" default_video_id=""]');
                    //ed.execCommand("mceInsertContent", 0, '<div class="flex-video widescreen"><iframe width="425" height="344" src="http://www.youtube.com/embed/'+id+'"][/youtube?wmode=transparent" frameborder="0" allowfullscreen=""> </iframe></div>');
                }
            });
        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : "Extra Buttons",
                author : "Narayan Prusty",
                version : "1"
            };
        }
    });

    tinymce.PluginManager.add("youtube_button_plugin", tinymce.plugins.youtube_button_plugin);
})();

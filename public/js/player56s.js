/*!
* Player 56s v0.5.1
* Copyright 2015 by Ivan Dymkov (http://dymio.net)
                and 56 STUFF (http://www.56stuff.com/)
* Licensed under the MIT license
* Inspired by Jouele 2.0.0
*   https://github.com/ilyabirman/Jouele
*   In fact, code of this plugin is reworked code of Jouele =)
*   based on commit 49ec04bfeb14c5617ef06b91746bdc3a5e940660
*/

var splitFilenameToTrackAndAuthor = function(filename) {
    var delimeter = ' || ';
    if (filename.indexOf(' \u2014 ') > -1) { delimeter = ' \u2014 '; }
    return filename.toString().split(delimeter);
}

var getTrackTitle = function(filename) {
    var parts = splitFilenameToTrackAndAuthor(filename);
    return parts.length > 1 ? parts[2] : parts[0]
}

var getTrackAuthor = function(filename) {
    var parts = splitFilenameToTrackAndAuthor(filename);
    return parts.length > 1 ? ('' + parts[1]) : ""
}

var getTrackAlbum = function(filename) {
    var parts = splitFilenameToTrackAndAuthor(filename);
    return parts.length > 1 ? ('' + parts[0]) : ""
}

var getTrackAlbumImg = function(filename) {
    var parts = splitFilenameToTrackAndAuthor(filename);
    return parts.length > 1 ? ('' + parts[3]) : ""
}

var getTrackID = function(filename) {
    var parts = splitFilenameToTrackAndAuthor(filename);
    return parts.length > 1 ? ('' + parts[4]) : ""
}

var formatTime = function(rawSeconds) {
    if (typeof rawSeconds !== "number") {
        return rawSeconds;
    }

    var seconds = Math.round(rawSeconds) % 60,
        minutes = ((Math.round(rawSeconds) - seconds) % 3600) / 60,
        hours = (Math.round(rawSeconds) - seconds - (minutes * 60)) / 3600;

    return (hours ? (hours + ":") : "") + ((hours && (minutes < 10)) ? "0" + minutes : minutes) + ":" + (seconds < 10 ? "0" + seconds : seconds);
};

var makeSeconds = function(time) {
    if (typeof time === "number") {
        return time;
    }

    var array = time.split(":").reverse(),
        seconds = 0;

    for (var i = 0; i < array.length; i++) {
        seconds += array[i] * Math.pow(60, i);
    }

    return seconds;
};

var updateLoadBar = function(instance, status) {
    if ((instance.fullyLoaded && instance.totalTime) || !instance.isPlayed) {
        return instance;
    }

    var roundedSeekPercent = Math.round(status.seekPercent); // because Safari sometimes shows 99.999999999

    if (roundedSeekPercent >= 100) {
        instance.fullyLoaded = true;
        instance.totalTime = status.duration;
    } else if (roundedSeekPercent > 0) {
        instance.totalTime = status.duration;
    } else {
        instance.totalTime = 0;
    }

    instance.$container.find(".player56s-timeline-load").css({"width": Math.floor(Math.min(100, roundedSeekPercent)) + "%"});

    return instance;
};

var updatePlayBar = function(instance, percents) {

    // instance.$container.find(".player56s-play-lift").css("left", percents  + "%");
    instance.$container.find(".player56s-timeline-done").css("width", percents + "%");

    return instance;
};

var updateTimeDisplay = function(instance, seconds) {
    // we haven't total time info
    instance.$container.find(".player56s-time-done").html(formatTime(seconds));

    return instance;
};

var willSeekTo = function(instance, seekPercent) {
    var percent = seekPercent.toFixed(2);

    if (percent < 0) {
        percent = 0;
    } else if (percent > 100) {
        percent = 100;
    }

    updatePlayBar(instance, percent);

    instance.$jPlayer.jPlayer("playHead", percent);

    if (instance.fullTimeDisplayed) {
        instance.seekTime = (instance.totalTime / 100) * percent;
        updateTimeDisplay(instance, instance.seekTime);
    } else if (instance.options.length) {
        instance.seekTime = (makeSeconds(instance.options.length) / 100) * percent;
        updateTimeDisplay(instance, instance.seekTime);
    } else {
        instance.seekTime = (makeSeconds(instance.options.length) / 100) * percent;
        updateTimeDisplay(instance, instance.seekTime);
    }

    var timelinedone = instance.$container.find(".player56s-timeline-done").width() / instance.$container.find('.player56s-timeline-done').parent().width() * 100;
    jQuery("#player56s-seek-percent").html(timelinedone);

    return instance;
};

var checkAndRunTicker = function(instance) {
    var titleCont = instance.$container.find(".player56s-title");
    if (!titleCont.length) { return instance; }
    var innerSpan = titleCont.children("span");
    if (innerSpan.length && ((innerSpan.height() - 10) > titleCont.height())) {
        // we need to activate ticker for title
        innerSpan.css({ 'display': 'block', 'position' : 'relative' }).width(titleCont.width());
        while ((innerSpan.height() - 10) > titleCont.height()) {
            innerSpan.width( innerSpan.width() + 5 );
        }

        var treset = function() {
            if (!this) { return false; }
            var $this = jQuery(this);
            var parCont = $this.parent();
            if (!parCont.length) { return false; }
            var diff = $this.width() - parCont.width();
            $this.animate({ "left": $this.css("left") }, 500, function() {
                $this.animate({ "left": "0" }, 2000, function() {
                    $this.animate({
                        "left": "-" + diff + "px"
                    }, (diff * 40), 'linear', treset);   
                });
                $this.delay( 500 );
            });
        };

        treset.call(innerSpan[0]);
    }
    return instance;
};

var checkAndRunTickerAlbum = function(instance) {
    var titleCont = instance.$container.find(".player56s-album");
    if (!titleCont.length) { return instance; }
    var innerSpan = titleCont.children("span");
    if (innerSpan.length && ((innerSpan.height() - 10) > titleCont.height())) {
        // we need to activate ticker for title
        innerSpan.css({ 'display': 'block', 'position' : 'relative' }).width(titleCont.width());
        while ((innerSpan.height() - 10) > titleCont.height()) {
            innerSpan.width( innerSpan.width() + 5 );
        }

        var treset = function() {
            if (!this) { return false; }
            var $this = jQuery(this);
            var parCont = $this.parent();
            if (!parCont.length) { return false; }
            var diff = $this.width() - parCont.width();
            $this.animate({ "left": $this.css("left") }, 500, function() {
                $this.animate({ "left": "0" }, 2000, function() {
                    $this.animate({
                        "left": "-" + diff + "px"
                    }, (diff * 40), 'linear', treset);   
                });
                $this.delay( 500 );
            });
        };

        treset.call(innerSpan[0]);
    }
    return instance;
};

var updateMediaSessionNull = function() {
    navigator.mediaSession.metadata = new MediaMetadata({
        title: null,
        artist: null,
        album: null,
        artwork: [{ src: null }]
    });
    return navigator.mediaSession.metadata;
};

var initMediaSession = function(filename) {     
    navigator.mediaSession.metadata = new MediaMetadata({
        title: getTrackTitle(filename),
        artist: getTrackAuthor(filename),
        album: getTrackAlbum(filename),
        artwork: [{ src: getTrackAlbumImg(filename) }]
    });
    return navigator.mediaSession.metadata;
};

function shuffle(arra1) {
    let ctr = arra1.length;
    let temp;
    let index;

    // While there are elements in the array
    while (ctr > 0) {
// Pick a random index
        index = Math.floor(Math.random() * ctr);
// Decrease ctr by 1
        ctr--;
// And swap the last element with it
        temp = arra1[ctr];
        arra1[ctr] = arra1[index];
        arra1[index] = temp;
    }
    return arra1;
}

function fileExists(url) {
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status;
}

function array_move(arr, old_index, new_index) {
    if (new_index >= arr.length) {
        var k = new_index - arr.length + 1;
        while (k--) {
            arr.push(undefined);
        }
    }
    arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);
    return arr; // for testing
};

function generateRandom(max) { // min and max included 
    var min = 1;
    return Math.floor(Math.random() * (max - min + 1) + min)
}

jQuery( function player56s($) { 
    var Clock = { 
        totalSeconds: 0, 
        start: function () { 
            var self = this; this.interval = setInterval(function () { 
                self.totalSeconds += 1; 
                $("#player56s-play-timer").text(parseInt(self.totalSeconds)); 
            }, 1000); 
        }, 
        
        pause: function () { 
            clearInterval(this.interval); 
            delete this.interval; 
        }, 
        resume: function () { 
            if (!this.interval) this.start(); 
        },
        stop: function () { 
            clearInterval(this.interval); 
            delete this.interval; 
            this.totalSeconds = 0; 
            $("#player56s-play-timer").text(parseInt(this.totalSeconds)); 
        } 
    }; 
    $.fn.player56s = function(options) {
        var relGroups = [];
        return this.each(function() {
            var $this = $(this),
                thisClass = $this.attr("class"),
                thisRel = $this.attr("rel"),
                thisIsMinimal = (thisClass.indexOf("minimal") > -1),
                canHaveGroup = (!thisIsMinimal && thisRel),
                skinClassPosition = thisClass.indexOf("player56s-skin-"),
                player56sInstance = $this.data("player56s"),
                audiofileLink_add = $("#player56s-addtrack ul li"),
                audiofileLink_remove = $("#player56s-removetrack"),
                audiofileLink_remove_all = $("#player56s-removetracks-all"),
                audiofileLink_currenttrack = $("#player56s-currenttrack"),
                audiofileLink_play_now = $("#player56s-playnow"),
                currenttrack_index = $("#player56s-sortable ul li"),
                playlist_shuffle = $("#player56s-shuffle"),
                playlist_no_shuffle = $("#player56s-no-shuffle ul li"),

                skin = "",
                goAndCreate = true;

            if (canHaveGroup) {
                for (var i = 0; i < relGroups.length; i++) {
                    if (relGroups[i].group == thisRel) {
                        var audiofileLink = $this.attr("href");
                        var filename = $this.html();
                        var datalength = $this.attr("data-length");
                        var audiopostid = $this.attr("postid");
                        relGroups[i].pl56s.addTrack(audiofileLink, filename, datalength, audiopostid);
                        $this.detach();
                        goAndCreate = false;
                        break;
                    }
                }
            }                    

            if (goAndCreate) {
                if (player56sInstance) {
                    if(typeof player56sInstance.tracks[player56sInstance.currentTrack] === undefined){
                        player56sInstance.removeAll();
                    }

                    if (audiofileLink_add[0] !== undefined ) {
                        var allready = 0;
                        player56sInstance.tracks.forEach(function(element, index) {
                            if (audiofileLink_add[2].innerText == element.postid) {
                                allready = 1;
                            }
                        }, this);
                        if ( allready == 0 ) {
                            player56sInstance.addTrack(audiofileLink_add[0].innerText, audiofileLink_add[1].innerText, audiofileLink_add[3].innerText, audiofileLink_add[2].innerText);
                            if (playlist_shuffle[0].innerText == "1") {
                                shuffle(player56sInstance.tracks);                    
                            }
                        }
                        player56sInstance.tracks.forEach(function(element, index) {
                            if (element.postid === '0' && player56sInstance.tracks.length >= 2) {
                                player56sInstance.pseudoPause();
                                player56sInstance.pause();
                                player56sInstance.tracks.splice(index, 1);
                                player56sInstance.switchTrack(true); 
                            }
                        }, this);
                    }
                    
                    player56sInstance.currentTrack = 0;
                    player56sInstance.tracks.forEach(function(element, index) {
                        var player56scurrenttrack = $("#player56s-currenttrack");
                        if(element.postid === player56scurrenttrack[0].innerText){
                            player56sInstance.currentTrack = index;
                        }
                    }, this);
            
                    if (audiofileLink_play_now[0] !== null ) {
                        player56sInstance.tracks.forEach(function(element, index) {
                            if (audiofileLink_play_now[0].innerText == element.postid) {
                                player56sInstance.sleep(50);
                                if (index == player56sInstance.currentTrack) {
                                    if (!player56sInstance.isPlaying) {
                                        player56sInstance.pseudoPlay();
                                        player56sInstance.play();
                                    }
                                    if (player56sInstance.isPlaying) {
                                        player56sInstance.pseudoPause();
                                        player56sInstance.pause();
                                    }  
                                } else {
                                    player56sInstance.sleep(100);
                                    player56sInstance.playNow(index);
                                    player56sInstance.pseudoPlay();
                                    player56sInstance.play();
                                }
                            }
                        }, this);
                    }
            
                    if ( audiofileLink_remove !== null ) {
                        var audiofileLink_remove_id = audiofileLink_remove[0].innerText; 
                        player56sInstance.tracks.forEach(function(element, index) {
                            if (element.postid == audiofileLink_remove_id) {
                                if (player56sInstance.tracks.length > 1) {
                                    if (player56sInstance.currentTrack === index) {
                                        if (player56sInstance.currentTrack === 0) {
                                            player56sInstance.switchTrack(true); 
                                            player56sInstance.tracks.splice(index, 1);
                                            player56sInstance.switchTrack(false); 
                                        } else if (player56sInstance.currentTrack === (player56sInstance.tracks.length - 1)) {
                                            player56sInstance.switchTrack(true);   
                                            player56sInstance.tracks.splice(index, 1);       
                                            player56sInstance.switchTrack(false);                                 
                                        } else {
                                            player56sInstance.switchTrack(true);
                                            player56sInstance.tracks.splice(index, 1);
                                            player56sInstance.switchTrack(false);
                                        }
                                    } else if (player56sInstance.currentTrack > index) {
                                        player56sInstance.tracks.splice(index, 1);
                                        player56sInstance.currentTrack = player56sInstance.currentTrack - 1;
                                    } else { 
                                        player56sInstance.tracks.splice(index, 1);
                                    }
                                } else {
                                    player56sInstance.removeAll();
                                }                             
                            }
                        }, this);
                    }

                    if (player56sInstance.tracks.length === 0) {
                        player56sInstance.removeAll();
                    }
                    
                    if ( audiofileLink_remove_all[0].innerText === "1" ) {
                        player56sInstance.removeAll();
                    }
            
                    if (playlist_shuffle[0].innerText === "1") {
                        var currentTrack = player56sInstance.tracks[player56sInstance.currentTrack];
                        shuffle(player56sInstance.tracks);
                        player56sInstance.tracks.forEach(function(element, index) {
                            if (element == currentTrack) {
                                player56sInstance.currentTrack = index;
                            } 
                        });               
                    }
                     
                    if (playlist_shuffle[0].innerText === "0") {
                        var tracks = [],               
                        currentTrack = player56sInstance.tracks[player56sInstance.currentTrack];
                        player56sInstance.tracks.forEach(function(element_, index) {
                            player56sInstance.tracks.forEach(function(element, index_) {
                                if ( playlist_no_shuffle[index_].innerHTML == player56sInstance.tracks[index].postid ) {                                 
                                    tracks[index_] = player56sInstance.tracks[index];
                                }
                            });
                        });
                        tracks.forEach(function(element, index) {
                            if ( currentTrack == tracks[index] ) {
                                player56sInstance.currentTrack = index;
                            }
                        });
                        player56sInstance.tracks = tracks;
                    }
            
                    if (currenttrack_index[0] !== undefined ) {
                        if (player56sInstance.currentTrack == parseInt(currenttrack_index[0].innerText)) {
                            player56sInstance.currentTrack = parseInt(currenttrack_index[1].innerText);
                        }
                        array_move(player56sInstance.tracks, currenttrack_index[0].innerText, currenttrack_index[1].innerText);
            
                        $.ajax({    
                            type: 'post',
                            url: shuffle_ajax_url,
                            data: {
                                'object_id': null,
                                'action': 'if_shuffle'
                            },
                            dataType: 'JSON',
                            success: function(data){
                                if (data == "0") {
                                    $.ajax({
                                        type: 'post',
                                        url: save_order_ajax_url,
                                        data: {
                                        //	'nonce': nonce,
                                            'object_id': player56sInstance.tracks.reverse(),
                                            'action': 'new_order'
                                        },
                                        success: function(data_) {
                                            //
                                        },
                                        error: function(error) {
                                            console.log(error);
                                        }
                                    });
                                }
                            },
                            error: function(errorThrown){
                                console.log(errorThrown);
                            }
                        });

                    }
            
                } else {
                    /* Create new instance */
                    if (skinClassPosition > 0) {
                        skin = thisClass.substr(skinClassPosition + 12, thisClass.indexOf(" ", skinClassPosition) > 0 ? thisClass.indexOf(" ", skinClassPosition) : thisClass.length);
                    }
                    var pl56si = new Player56s($this, $.extend({}, $.fn.player56s.defaults, options, $this.data(), {skin: skin}));

                    if (canHaveGroup) {
                        relGroups.push({ group: thisRel, pl56s: pl56si });                         
                    } else {
                        pl56si.$container.find(".player56s-title").html('<span>Nothing in the playlist</span>');
                        pl56si.$container.find(".player56s-author").html('<span>Music Player</span>');
                        pl56si.$container.find(".player56s-album").html('<span>Just another WordPress site</span>');
                        pl56si.$container.find(".player56s-album-img").html('<img src="' + base_url + '/wp-content/plugins/McPlayer/public/css/blue-note.png"></img>');                   
                    }
                }
            }
        });
    };

    $.fn.player56s.defaults = {
        swfPath: "",
        swfFilename: "",
        solution: "html",
        supplied: "mp3",
        volume: 1,
        length: 1,
        scrollOnSpace: false,
        pauseOnSpace: true,
        hideTimelineOnPause: false,
        playlistOptions: {
            enableRemoveControls: true
        },
        smoothPlayBar: true,
        keyEnabled: true,
        skin: ""
    };

    class Player56s {
        constructor($link, options) {
            this.version = "1.0.0";
            this.$link = $link;
            this.options = options;
            this.minimal = $link.hasClass('minimal');
            this.isPlaying = false;
            this.isPlayed = false;
            this.totalTime = 0;
            this.fullyLoaded = false;
            this.fullTimeDisplayed = false;
            this.seekTime = 0;
            this.waitForLoad = true;
            this.preloaderTimeout = 0;
            this.isSeeking = false;
            this.tracks = [];
            this.currentTrack = 0;
            this.init();
            this.pseudoPause();
            this.pause();
        }
        init() {
            this.tracks.push({
                audiofileLink: this.$link.attr("href"),
                filename: this.$link.html(),
                length: this.$link.attr("data-length"),
                postid: this.$link.attr("postid")
            });
            this.checkOptions();
            this.createDOM();
            this.initPlayerPlugin();
            this.bindEvents();
            this.insertDOM();
        }
        sleep(milliseconds) {
            var start = new Date().getTime();
            for (var i = 0; i < 1e7; i++) {
                if ((new Date().getTime() - start) > milliseconds){
                    break;
                }
            }
        }
        GetSeek() {
            var audiofileLink_add = $("#player56s-seek-percent");
            var timelinedone = $(".player56s-timeline-done").width() / $('.player56s-timeline-done').parent().width() * 100;
            audiofileLink_add.html(timelinedone);
            return timelinedone;
        }
        addTrack(audiofileLink, filename, length, postid) {
            this.tracks.push({
                audiofileLink: audiofileLink,
                filename: filename,
                length: length,
                postid: postid
            });
            this.$container.find(".player56s-track-next").addClass('enabled');
            this.$container.find(".player56s-track-prev").addClass('enabled');
        }
        removeAll() {
            this.stop();
            this.tracks = [];
            this.addTrack('#', '', '0', '0');
            this.currentTrack = 0;
            this.seekTime = 0;
            this.$container.find(".player56s-title").html('<span>Nothing in the playlist</span>');
            this.$container.find(".player56s-author").html('<span>Music Player</span>');
            this.$container.find(".player56s-album").html('<span>Just another WordPress site</span>');
            this.$container.find(".player56s-album-img").html('<img src="' + window.location.origin + '/wp-content/plugins/McPlayer/public/css/blue-note.png"></img>');
            $("#rs-saved-for-later").html('<li id="rs-saved-for-later-nothing" style="text-align: center; padding:15px 0px;">Nothing in the playlist</li>');
        }
        destroy() {
            var uniqueID = this.$container.attr("id");
            this.$container.after(this.$link).remove();
            $(document).off("." + uniqueID);
            this.$link.removeData("player56s");
            return this.$link;
        }
        stop() {
            if (typeof this.$jPlayer !== "undefined" && this.$jPlayer.jPlayer) {
                this.$jPlayer.jPlayer( "stop" );
                this.$jPlayer.jPlayer("setMedia", {
                    mp3: '#'
                });
                Clock.stop();
            }
            return this;
        }
        pseudoPause() {
            this.$container.removeClass("status-playing");
            this.$container.addClass("status-onpause");
            this.$container.removeClass("player56s-status-playing");
        }
        pause() {
            if (typeof this.$jPlayer !== "undefined" && this.$jPlayer.jPlayer) {
                $("#rs-item-" + this.tracks[this.currentTrack].postid + "").removeClass('playing');
                $("#play-now-id-" + this.tracks[this.currentTrack].postid + "").removeClass('onplay');
                $("#add-play-now-id-" + this.tracks[this.currentTrack].postid + "").removeClass('onplay');
                $("#play-now-id-" + this.tracks[this.currentTrack].postid + "").addClass('onpause');
                $("#add-play-now-id-" + this.tracks[this.currentTrack].postid + "").addClass('onpause');     
                if (this.isPlaying && this.tracks[this.currentTrack].postid !== '0') {               
                    this.isPlaying = false;
                    this.waitForLoad = false;
                    this.$jPlayer.jPlayer("pause");
                    Clock.pause();
                }
            }
            return this;
        }
        pseudoPlay() {
            $(document).trigger("player56s-pause", this);
            this.$container.addClass("status-playing");
            this.$container.removeClass("status-onpause");
            this.$container.addClass("player56s-status-playing");
        }
        play() {
            if (typeof this.$jPlayer !== "undefined" && this.$jPlayer.jPlayer) {
                $("#rs-item-" + this.tracks[this.currentTrack].postid + "").addClass("playing");
                $("#play-now-id-" + this.tracks[this.currentTrack].postid + "").addClass('onplay');
                $("#add-play-now-id-" + this.tracks[this.currentTrack].postid + "").addClass('onplay');
                $("#play-now-id-" + this.tracks[this.currentTrack].postid + "").removeClass('onpause');
                $("#add-play-now-id-" + this.tracks[this.currentTrack].postid + "").removeClass('onpause');
                if (!this.isPlaying && this.tracks[this.currentTrack].postid !== '0') {
                    this.isPlayed = true;
                    this.waitForLoad = true;
                    this.$jPlayer.jPlayer("play");
                    this.setVolume(1, 1);
                    Clock.resume();
                }
            }
            return this;
        }
        setVolume(lvl, maxLvl) {
            var changed = false;
            if (typeof this.$jPlayer !== "undefined" && this.$jPlayer.jPlayer) {
                lvl = lvl || 0;
                maxLvl = maxLvl || 1;
                if (lvl > maxLvl) {
                    lvl = maxLvl;
                }
                this.$jPlayer.jPlayer("volume", lvl / maxLvl);
                changed = true;
            }
            return changed;
        }
        playNow(index) {
            if (typeof this.$jPlayer !== "undefined" && this.$jPlayer.jPlayer) {
                var status = null;
                if (this.$container.hasClass("status-onpause")) {
                    status = 0;
                }
                if (this.$container.hasClass("status-playing")) {
                    status = 1;
                }

                this.pseudoPause();
                this.pause();

                var player56splaytimer = $("#player56s-play-timer");
                var currentTracklength = this.tracks[this.currentTrack].length;
                var currentTracklengthsechalf = parseInt(currentTracklength) * 0.75;
                if(player56splaytimer[0].innerText >= parseInt(currentTracklengthsechalf)){
                    $.ajax({    
                        type: 'post',
                        url: count_playlist_ajax_url,
                        data: {
                            'object_id': this.tracks[this.currentTrack].postid,
                            'action': 'count_play'
                        },
                        dataType: 'JSON',
                        success: function(data){
                            //
                        },
                        error: function(errorThrown){
                            console.log(errorThrown);
                        }
                    });
                }
        
                this.stop();

                if (index == -1){
                    var track = this.tracks[this.currentTrack];
                } else {
                    this.currentTrack = index;
                    var track = this.tracks[this.currentTrack];
                }
                $("#player56s-currenttrack").html(track.postid);
                
                this.$jPlayer.jPlayer("setMedia", {
                    mp3: track.audiofileLink
                });

                this.$container.find(".player56s-title").html('<span>' + getTrackTitle(track.filename) + '</span>');
                this.$container.find(".player56s-author").html('<span>' + getTrackAuthor(track.filename) + '</span>');
                this.$container.find(".player56s-album").html('<span>' + getTrackAlbum(track.filename) + '</span>');
                this.$container.find(".player56s-time").html(track.length ? formatTime(makeSeconds(track.length)) : "");
                this.$container.find(".player56s-album-img").html('<span><img src="' + getTrackAlbumImg(track.filename) + '"></img></span>');

                if (status == 1) {
                    $("#rs-item-" + this.tracks[this.currentTrack].postid + "").addClass('playing');
                    this.pseudoPlay();
                    this.play();
                }
                
                initMediaSession(track.filename);

                checkAndRunTicker(this);
                checkAndRunTickerAlbum(this);

            }
        }
        switchTrack(to_next) {
            if (to_next === undefined) {
                to_next = true;
            } // next by default
            if (typeof this.$jPlayer !== "undefined" && this.$jPlayer.jPlayer && this.tracks.length >= 1 && this.tracks[this.currentTrack].postid !== '0' ) {
                var timelinedone = $(".player56s-timeline-done").width() / $('.player56s-timeline-done').parent().width() * 100;
                var status = null;
                if (this.$container.hasClass("status-onpause")) {
                    status = 0;
                }
                if (this.$container.hasClass("status-playing")) {
                    status = 1;
                }

                this.pseudoPause();
                this.pause();

                var player56splaytimer = $("#player56s-play-timer");
                var currentTracklength = this.tracks[this.currentTrack].length;
                var currentTracklengthsechalf = parseInt(currentTracklength) * 0.75;
                if(player56splaytimer[0].innerText >= parseInt(currentTracklengthsechalf)){
                    $.ajax({    
                        type: 'post',
                        url: count_playlist_ajax_url,
                        data: {
                            'object_id': this.tracks[this.currentTrack].postid,
                            'action': 'count_play'
                        },
                        dataType: 'JSON',
                        success: function(data){
                            //
                        },
                        error: function(errorThrown){
                            console.log(errorThrown);
                        }
                    });
                }

                this.stop();

                if (!to_next && (parseInt(timelinedone) > 5)) {
                    this.currentTrack = this.currentTrack;
                } else {
                    if (to_next && (this.currentTrack === (this.tracks.length - 1))) {
                        this.currentTrack = 0;
                    }
                    else if (!to_next && this.currentTrack === 0) {
                        this.currentTrack = this.tracks.length + 1;
                    }
                    else {
                        this.currentTrack = this.currentTrack + (to_next ? 1 : -1);
                    }
                }

                if (this.tracks[this.currentTrack] === undefined) {
                    this.currentTrack = 0;
                }
                
                var track = this.tracks[this.currentTrack];
                
                $("#player56s-currenttrack").html(track.postid);

                this.$jPlayer.jPlayer("setMedia", {
                    mp3: track.audiofileLink
                });

                this.$container.find(".player56s-title").html('<span>' + getTrackTitle(track.filename) + '</span>');
                this.$container.find(".player56s-author").html('<span>' + getTrackAuthor(track.filename) + '</span>');
                this.$container.find(".player56s-album").html('<span>' + getTrackAlbum(track.filename) + '</span>');
                this.$container.find(".player56s-time").html(track.length ? formatTime(makeSeconds(track.length)) : "");
                this.$container.find(".player56s-album-img").html('<span><img src="' + getTrackAlbumImg(track.filename) + '"></img></span>');

                if (status == 1) {
                    this.pseudoPlay();
                    this.play();
                }

                initMediaSession(track.filename);

                checkAndRunTicker(this);
                checkAndRunTickerAlbum(this);
            }
        }
        onPause() {
            this.isPlaying = false;
            this.isSeeking = false;
            this.$container.removeClass("player56s-status-playing");
        }
        onStop() {
            this.isPlaying = false;
            this.seekTime = 0;
            this.isSeeking = false;
            this.$container.removeClass("player56s-status-playing");
        }
        onPlay() {
            $(document).trigger("player56s-pause", this);
            this.$container.addClass("player56s-status-playing");
            this.isPlaying = true;
            this.isPlayed = true;
        }
        checkOptions() {
            //
        }
        createDOM() {
            var $container = $(document.createElement("div")), $invisibleObject = $(document.createElement("div")), $infoArea = $(document.createElement("div")), filename = this.tracks[0].filename, self = this;
            var createMinimanContentDOM = function () {
                return [
                    $(document.createElement("div")).addClass("player56s-timeline").append($(document.createElement("div")).addClass("player56s-timeline-load"), $(document.createElement("div")).addClass("player56s-timeline-done")),
                    $(document.createElement("div")).addClass("player56s-button"),
                    $(document.createElement("div")).addClass("player56s-volume").append($(document.createElement("div")).addClass("player56s-vol-pin").addClass("active").addClass("zero-vol"), $(document.createElement("div")).addClass("player56s-vol-pin").addClass("active"), $(document.createElement("div")).addClass("player56s-vol-pin").addClass("active"), $(document.createElement("div")).addClass("player56s-vol-pin").addClass("active"), $(document.createElement("div")).addClass("player56s-vol-pin"), $(document.createElement("div")).addClass("player56s-vol-pin").addClass("max-vol")),
                    $(document.createElement("div")).addClass("player56s-time").html(self.options.length ? formatTime(makeSeconds(self.options.length)) : "")
                ];
            };
            var createNormalContentDOM = function () {
                return [
                    $(document.createElement("div")).addClass("player56s-album-img").html('<span><img src="' + getTrackAlbumImg(filename) + '"></img></span>'),
                    $(document.createElement("div")).addClass("player56s-title").html('<span>' + getTrackTitle(filename) + '</span>'),
                    $(document.createElement("div")).addClass("player56s-author").html('<span>' + getTrackAuthor(filename) + '</span>'),
                    $(document.createElement("div")).addClass("player56s-bottom").append($(document.createElement("div")).addClass("player56s-time-done").html("0:00"), $(document.createElement("div")).addClass("player56s-album").html('<span>' + getTrackAlbum(filename) + '</span>'), $(document.createElement("div")).addClass("player56s-time").html(self.options.length ? formatTime(makeSeconds(self.options.length)) : "")),
                    $(document.createElement("div")).addClass("player56s-timeline").append($(document.createElement("div")).addClass("player56s-timeline-load"), $(document.createElement("div")).addClass("player56s-timeline-done")),
                    $(document.createElement("div")).addClass("player56s-button"),
                    $(document.createElement("div")).addClass("player56s-volume").append($(document.createElement("div")).addClass("player56s-vol-pin").addClass("max-vol").addClass("active"), $(document.createElement("div")).addClass("player56s-vol-pin").addClass("active"), $(document.createElement("div")).addClass("player56s-vol-pin").addClass("active"), $(document.createElement("div")).addClass("player56s-vol-pin").addClass("active"), $(document.createElement("div")).addClass("player56s-vol-pin").addClass("active"), $(document.createElement("div")).addClass("player56s-vol-pin").addClass("active"), $(document.createElement("div")).addClass("player56s-vol-pin").addClass("active"), $(document.createElement("div")).addClass("player56s-vol-pin").addClass("active").addClass("zero-vol")),
                    $(document.createElement("div")).addClass("player56s-tracks").append($(document.createElement("div")).addClass("player56s-track-nav").addClass("player56s-track-prev"), $(document.createElement("div")).addClass("player56s-track-nav").addClass("player56s-track-next"))
                ];
            };
            var createContentAreaDOM = function () {
                return (self.minimal ? createMinimanContentDOM() : createNormalContentDOM());
            };
            this.$container = $container
                .data("player56s", this)
                .addClass("player56s")
                .addClass(self.minimal ? "minimal" : "normal")
                .attr("id", "player56s-ui-zone")
                .append($invisibleObject.addClass("player56s-invisible-object"), $infoArea.addClass("player56s-content").append(createContentAreaDOM()));
            return this;
        }
        initPlayerPlugin() {
            var self = this, $jPlayer = self.$container.find(".player56s-invisible-object");
            this.$jPlayer = $jPlayer.jPlayer({
                solution: "html",
                wmode: "gpu",
                preload: "auto",
                smoothPlayBar: true,
                keyEnabled: true,
                swfPath: self.options.swfPath + self.options.swfFilename,
                supplied: self.options.supplied,
                volume: self.options.volume,
                ready: function () {
                    var audiofileLink = self.tracks[0].audiofileLink, uniqueID = self.$container.attr("id");

                    self.$jPlayer.jPlayer("setMedia", {
                        mp3: audiofileLink
                    });

                    $("#player56s-currenttrack").html(self.tracks[self.currentTrack].postid);

                    self.$container.find(".player56s-button").on("click", function (event) {
                        event.stopPropagation();
                        event.preventDefault();
                        event.stopImmediatePropagation();
                        if (!self.isPlaying && self.tracks[self.currentTrack].postid !== '0') {
                            self.pseudoPlay.call(self);
                            self.play.call(self);
                        } else {
                            self.pseudoPause.call(self);
                            self.pause.call(self);
                        }
                    });
                    self.$container.find(".player56s-volume .player56s-vol-pin").on("click", function (event) {
                        event.stopPropagation();
                        event.preventDefault();
                        event.stopImmediatePropagation();
                        var $pin = $(this);
                        var $pinsBefore = self.minimal ? $pin.prevAll() : $pin.nextAll();
                        var lvl = $pinsBefore.length;
                        var maxLvl = $pin.siblings().length;
                        if (self.setVolume.call(self, lvl, maxLvl)) {
                            $pinsBefore.addClass('active');
                            $pin.addClass('active');
                            var $pinsAfter = self.minimal ? $pin.nextAll() : $pin.prevAll();
                            $pinsAfter.removeClass('active');
                        }
                    });
                    self.$container.find(".player56s-track-nav").on("click", function (event) {
                        event.stopPropagation();
                        event.preventDefault();
                        event.stopImmediatePropagation();
                        self.switchTrack($(this).hasClass('player56s-track-next'));
                    });
                    self.$container.find(".player56s-timeline").on("mousedown." + uniqueID, function (event) {
                        if (event.which !== 1) {
                            return false;
                        }
                        event.stopPropagation();
                        event.preventDefault();
                        event.stopImmediatePropagation();
                        self.isSeeking = true;
                        var $this = $(this), clickPoint = ((event.pageX - $this.offset().left) / $this.width()) * 100;
                        $(document).off("mouseup." + uniqueID).one("mouseup." + uniqueID, function () {
                            self.isSeeking = false;
                        });
                        $(document).off("mousemove." + uniqueID).on("mousemove." + uniqueID, function (event) {
                            event.stopPropagation();
                            event.preventDefault();
                            event.stopImmediatePropagation();
                            if (!self.isSeeking) {
                                return false;
                            }
                            var clickPoint = ((event.pageX - $this.offset().left) / $this.width()) * 100;
                            if(self.tracks[self.currentTrack].postid !== '0'){
                                willSeekTo(self, clickPoint);
                            }
                        });
                        if(self.tracks[self.currentTrack].postid !== '0'){
                            willSeekTo(self, clickPoint);
                        }
                    });
                },
                pause: function () {
                    self.onPause();
                },
                stop: function () {
                    self.onStop();
                },
                ended: function () {
                    self.switchTrack();
                    self.pseudoPlay();
                    self.play();
                },
                error: function () {
                    if(self.tracks.length === 1){
                        self.onStop();
                    } else {
                        self.switchTrack();
                    }
                },
                play: function () {
                    self.onPlay();
                },
                progress: function (event) {
                    updateLoadBar(self, event.jPlayer.status);
                    updateTimeDisplay(self, event.jPlayer.status.currentTime);
                },
                timeupdate: function (event) {
                    updateLoadBar(self, event.jPlayer.status);
                    updateTimeDisplay(self, event.jPlayer.status.currentTime);
                    updatePlayBar(self, event.jPlayer.status.currentPercentAbsolute.toFixed(2));
                    $("#player56s-seek-current-percent").html(event.jPlayer.status.currentPercentAbsolute.toFixed(2));
                    if (self.waitForLoad) {
                        self.waitForLoad = false;
                        self.seekTime = (self.totalTime / 100) * $("#player56s-seek-percent").html();
                    }
                    if (self.$container.hasClass("status-playing")) {
                        self.pseudoPlay();
                        self.play();
                    }
                }
            });
            return this;
        }
        insertDOM() {
            this.$link.after(this.$container);
            this.$link.data("player56s", this);
            this.$link.detach();
            checkAndRunTicker(this);
            checkAndRunTickerAlbum(this);
            return this;
        }
        getCookie(c_name) {
            var i, x, y, ARRcookies = document.cookie.split(";");
            for (i = 0; i < ARRcookies.length; i++) {
                x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
                y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
                x = x.replace(/^\s+|\s+$/g, "");
                if (x == c_name) {
                    return unescape(y);
                }
            }
        }
        DeleteCookie(name) {
            document.cookie = name + '=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
        }
        bindEvents() {
            var self = this, uniqueID = self.$container.attr("id");
        
            var Player56sState = self.getCookie("Player56sState");
            var Player56sSeek = self.getCookie("Player56sSeek");
            if(Player56sState && Player56sSeek){
                var Refersh = setInterval(function(){
                    var player56scurrenttrack = $("#player56s-currenttrack");
                    var player56scurrentseek = $("#player56s-seek-current-percent");
                    self.tracks.forEach(function(element, index) {
                        if(parseInt(element.postid) === parseInt(Player56sState)){
                            self.playNow(parseInt(index));
                            willSeekTo(self, parseInt(Player56sSeek));
                        }
                    });

                    if(player56scurrenttrack[0].innerText === Player56sState && player56scurrentseek > Player56sSeek) {
                        clearInterval(Refersh);
                        self.DeleteCookie(Player56sState);
                        self.DeleteCookie(Player56sSeek);
                    }
                },2500);
            }

            $(document).on("player56s-pause." + uniqueID, function (event, triggeredPlayer56s) {
                if (self !== triggeredPlayer56s) {
                    self.pause();
                }
            });
            // Android mediasession nodification for extrenal btn while the mobile device screen is off
            navigator.mediaSession.setActionHandler('play', function() {
                self.pseudoPlay();
                self.play();
            });
            navigator.mediaSession.setActionHandler('pause', function() {
                self.pseudoPause();
                self.pause();
            });
            navigator.mediaSession.setActionHandler('previoustrack', function () {
                self.switchTrack(false);
            });
            navigator.mediaSession.setActionHandler('nexttrack', function () {
                self.switchTrack(true);
            });
            navigator.mediaSession.setActionHandler('seekforward', function () {
                var timelinedone = $(".player56s-timeline-done").width() / $('.player56s-timeline-done').parent().width() * 100;
                var timeSeek = parseInt(timelinedone) + 5;
                willSeekTo(self, timeSeek);
            });
            navigator.mediaSession.setActionHandler('seekbackward', function () {
                var timelinedone = $(".player56s-timeline-done").width() / $('.player56s-timeline-done').parent().width() * 100;
                var timeSeek = parseInt(timelinedone) - 5;
                willSeekTo(self, timeSeek);
            });      
            initMediaSession(self.tracks[self.currentTrack].filename);
            $(document).on("keydown." + uniqueID, function (event) {
                if (event.keyCode === 176) {
                    event.preventDefault();
                    event.stopPropagation();
                    self.switchTrack(true);
                }
                if (event.keyCode === 177) {
                    event.preventDefault();
                    event.stopPropagation();
                    self.switchTrack(false);
                }
                if (event.keyCode === 179) {
                    if (self.isPlaying) {
                        self.$jPlayer.jPlayer("pause");
                    } else {
                        self.$jPlayer.jPlayer("play");
                    }
                }
            });
        }
    }

});

jQuery(document).ready(function($) {
    jQuery(".player56s").player56s($);
});
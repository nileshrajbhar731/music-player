<style>
    @import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap");

    * {
        outline: none;
        box-sizing: border-box;

    }

    .muisc-data {
        background-image: linear-gradient(0deg,
                rgba(247, 247, 247, 1) 23.8%,
                rgba(252, 221, 221, 1) 92%);
        color: #000;
        font-family: "Open Sans", sans-serif;
        margin: 0;
        height: 150px;
        width: 1275px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .music-container {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 20px 20px 0 rgba(252, 169, 169, 0.6);
        display: flex;
        padding: 20px 30px;
        position: relative;
        margin: 100px 0;
        z-index: 10;
        width: 1169px;
    }

    .img-container {
        position: relative;
        width: 110px;
    }

    .img-container::after {
        content: "";
        background-color: #fff;
        border-radius: 50%;
        position: absolute;
        bottom: 85%;
        left: 50%;
        width: 20px;
        height: 20px;
        transform: translate(-50%, 50%);
        box-shadow: 0 0 0px 10px #000;
    }

    .img-container img {
        border-radius: 50%;
        object-fit: cover;
        height: 110px;
        width: inherit;
        position: absolute;
        bottom: 0;
        left: 0;
        animation: rotate 3s linear infinite;
        animation-play-state: paused;
    }

    .music-container.play .img-container img {
        animation-play-state: running;
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .navigation {
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
    }

    .action-btn {
        background-color: #fff;
        border: 0;
        /* color: #dfdbdf; */
        font-size: 20px;
        color: #000;
        cursor: pointer;
        padding: 10px;
        margin: 0 20px;
    }

    .action-btn.action-btn-big {
        /* color: #cdc2d0; */
        font-size: 30px;

    }

    .music-info {
        background-color: rgba(255, 255, 255, 0.5);
        width: calc(100% - 40px);
        padding: 10px 10px 10px 150px;
        border-radius: 15px 15px 0px 0px;
        position: absolute;
        top: 0;
        left: 20px;
        opacity: 0;
        transform: translateY(0%);
        transition: transform 0.3s ease-in, opacity 0.3s ease-in;
        z-index: 0;
    }

    .music-container.play .music-info {
        opacity: 1;
        transform: translateY(-100%);
    }

    .music-info h4 {
        margin: 0;
    }

    .progress-container {
        background-color: #fff;
        border: 5px;
        cursor: pointer;
        margin: 10px 0;
        height: 9px;
        width: 100%;
    }

    .progress {
        background-color: #fe8daa;
        /* border-radius: 5px; */
        height: 100%;
        width: 0%;
        transform: width 0.1s linear;
    }

    .more {
        margin-left: 33%;
    }

    #repeat.active {
        color: red;
    }

    #volumeRange {
        display: none;
    }

    #heart {
        font-size: 25px;
    }
</style>

<div class="muisc-data">

    <div class="music-container" id="music-container">
        <div class="music-info">
            <h4 class="title" id="title"></h4>
            <div class="progress-container" id="progress-container">
                <div class="progress" id="progress"></div>
            </div>
        </div>
        <audio id="audio"></audio>
        <div class="img-container">
            <img src="https://www.virtualdj.com/images/products/icon_mp3.png" alt="music-cover" id="cover" />
        </div>
        <div class="row">
            <div class="navigation">
                <button class="action-btn action-btn-big">
                    <i class="fa-solid fa-shuffle"></i>
                </button>
                <button id="prev" class="action-btn">
                    <i class="fa fa-backward" aria-hidden="true"></i>
                </button>
                <button id="play" class="action-btn action-btn-big">
                    <i class="fa fa-play" aria-hidden="true"></i>
                </button>
                <button id="next" class="action-btn">
                    <i class="fa fa-forward" aria-hidden="true"></i>
                </button>
                <button class="action-btn">
                    <i class="fa-solid fa-repeat" id="repeat"></i>
                </button>
                <button class="action-btn">
                    <i class="fa-regular fa-heart" id="heart"></i>
                </button>
            </div>
            <div class="navigation more">

                <button class="action-btn">
                    <h4 class="title" id="time">00:00</h4>
                    <h4 class="title" id="duration"></h4>
                </button>
                <button class="action-btn">
                    <h4>AB</h4>
                </button>
                <button id="audio-leval" class="action-btn">
                    <input type="range" name="" id="volumeRange" min="0" max="1" step="0.1">
                    <i class="fa-solid fa-volume-high" id="volume"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@section('javascript')
    <script>
        const musicContainer = document.getElementById("music-container");
        const playBtn = document.getElementById("play");
        const prevBtn = document.getElementById("prev");
        const nextBtn = document.getElementById("next");
        const audio = document.getElementById("audio");
        const progress = document.getElementById("progress");
        const progressContainer = document.getElementById("progress-container");
        const title = document.getElementById("title");
        const cover = document.getElementById("cover");
        const audioCurrentTime = document.getElementById("time");
        const audioDuration = document.getElementById("duration");
        const repeat = document.getElementById("repeat");
        const volumeBtn = document.getElementById("volume");
        const volumeRange = document.getElementById("volumeRange");
        var playButtons = document.querySelectorAll('.play-button');
        var likeBtn = document.getElementById('heart');

        var currentFileIndex = null;

        // check Headphone jack


        playButtons.forEach(function(button) {
            button.addEventListener('click', function() {

                currentFileIndex = Array.from(playButtons).indexOf(button);
                loadSong(songs[currentFileIndex]);
                // console.log(currentFileIndex);
                musicContainer.classList.add("play");
                playBtn.querySelector("i.fa").classList.remove("fa-play");
                playBtn.querySelector("i.fa").classList.add("fa-pause");
                audio.play();
            });
        });

        // Songs Titles
        const songs = [];
        @foreach ($musics as $music)
            var music = {
                title: '{{$music['title'] }}',
                url: 'audio/{{ $music['url'] }}',
                playtime: '{{ $music['playtime'] }}',
                img: '{{ $music['img'] }}'
            };
            songs.push(music);
            @endforeach

        // KeepTrack of song
        let songIndex = 0;
        // Initially load song details into DOM
        loadSong(songs[songIndex]);
        // Update song details
        function loadSong(song) {
            title.innerText = song.title;
            audio.src = song.url;
            cover.src = song.img;
            audioDuration.innerText = song.playtime;
        }
        // Play Song
        function playSong() {

            musicContainer.classList.add("play");
            playBtn.querySelector("i.fa").classList.remove("fa-play");
            playBtn.querySelector("i.fa").classList.add("fa-pause");
            audio.play();
        }
        // Pause Song
        function pauseSong() {
            musicContainer.classList.remove("play");
            playBtn.querySelector("i.fa").classList.add("fa-play");
            playBtn.querySelector("i.fa").classList.remove("fa-pause");
            audio.pause();
        }
        // Previous Song
        function prevSong() {
            songIndex--;
            if (songIndex < 0) {
                songIndex = songs.length - 1;
            }
            loadSong(songs[songIndex]);
            playSong();
        }
        // Next Song
        function nextSong() {
            songIndex++;
            if (songIndex > songs.length - 1) {
                songIndex = 0;
            }
            loadSong(songs[songIndex]);
            playSong();
        }
        // Update Progress bar
        function updateProgress(e) {
            const {
                duration,
                currentTime
            } = e.srcElement;
            const progressPerCent = (currentTime / duration) * 100;
            progress.style.width = `${progressPerCent}%`;
            audioCurrentTime.innerText = formatTime(currentTime);

        }

        // Format time as minutes:seconds
        function formatTime(time) {
            var minutes = Math.floor(time / 60);
            var seconds = Math.floor(time % 60);
            return (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
        }
        // Set Progress
        function setProgress(e) {
            const width = progressContainer.clientWidth;
            const clickX = e.offsetX;
            if (!width || isNaN(clickX)) {
                console.error("Invalid progress bar dimensions or click position");
                return;
            }
            const duration = audio.duration;
            if (isNaN(duration)) {
                console.warn("Audio duration is not available yet");
                return;
            }
            audio.currentTime = (clickX / width) * duration;
            console.log(`Setting audio playback time to ${audio.currentTime}`);
            audio.play();
        }

        // Event Listeners
        playBtn.addEventListener("click", () => {
            const isPlaying = musicContainer.classList.contains("play");
            if (isPlaying) {
                pauseSong();
            } else {
                playSong();
            }
        });

        // song repeat function

        function SongRepeat() {
            console.log(audio.loop);
            if (audio.loop === false) {
                audio.loop = true;
                repeat.classList.add('active');
                console.log('active');
            } else {
                audio.loop = false;
                repeat.classList.remove('active');
                console.log('stop');
            }
        }

        // song volume
        function volume(e) {
            audio.volume = e.target.value;
            if (e.target.value < "0.5") {
                volumeBtn.classList.add("fa-volume-low");
                volumeBtn.classList.remove("fa-volume-high");
            } else {
                volumeBtn.classList.add("fa-volume-high");
                volumeBtn.classList.remove("fa-volume-low");

            }

            if (e.target.value === "0") {

                volumeBtn.classList.add("fa-volume-off");
                volumeBtn.classList.remove("fa-volume-low");

            } else {
                volumeBtn.classList.add("fa-volume-low");
                volumeBtn.classList.remove("fa-volume-off");
            }
        }

        // volume Show
        function volumeShow() {
            console.log(volumeRange.style.display);
            if (volumeRange.style.display === '' || volumeRange.style.display === 'none') {
                volumeRange.value = audio.volume;
                volumeRange.style.display = 'block';
            } else {
                volumeRange.style.display = 'none';
            }

            if (audio.volume < 0.5) {
                volumeBtn.classList.add("fa-volume-low");
                volumeBtn.classList.remove("fa-volume-high");
            } else {
                volumeBtn.classList.add("fa-volume-high");
                volumeBtn.classList.remove("fa-volume-low");

            }

        }

        function likeSong() {
            likeBtn.classList.add("fa-solid");
            likeBtn.classList.remove("fa-regular");
        }



        // change volume
        volumeBtn.addEventListener("click", volumeShow);
        volumeRange.addEventListener("change", volume);
        // repeat song 
        repeat.addEventListener("click", SongRepeat);
        // Change Song
        prevBtn.addEventListener("click", prevSong);
        nextBtn.addEventListener("click", nextSong);
        // Time/Song Update
        audio.addEventListener("timeupdate", updateProgress);
        // // Click On progress Bar
        progressContainer.addEventListener("click", setProgress);
        // Song End
        audio.addEventListener("ended", nextSong);
        //  like a song 
        likeBtn.addEventListener("click", likeSong);
    </script>
@endsection

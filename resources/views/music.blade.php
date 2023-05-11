@section('styles')
    <link href="{{ asset('css/music.css') }}" rel="stylesheet">
@endsection

<style>
    .card-slider {
        position: relative;
        width: 100%;
        height: 358px;
        overflow: hidden;
        /* background: blue; */
        /* position: relative; */
    }

    .card-slider-wrapper {
        position: absolute;
        display: flex;
        width: 100%;
        height: 100%;
        transition: transform 0.5s ease-in-out;
    }

    /* .card {
  flex: 0 0 33.33%;
  margin: 0 20px;
  padding: 20px;
  border: 1px solid #ccc;
  box-sizing: border-box;
  text-align: center;
}

.card img {
  max-width: 100%;
  height: auto;
}

.card h3 {
  margin-top: 20px;
  font-size: 20px;
}

.card p {
  margin-top: 10px;
  font-size: 16px;
} */

    .card-slider-controls {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
    }

    .card-slider-controls button {
        margin: 0 10px;
        padding: 10px 20px;
        background-color: #333;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    .card-slider-controls button:hover {
        background-color: #555;
    }

    .card-header {
        background: gray;
        margin: 10px;
        text-align: center;
    }

    .card {
        flex: 0 0 24.33%;
        margin: 0px 20px;
        padding: 11px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        text-align: center;
        position: relative;
    }

    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .container {
        padding: 2px 16px;
    }

    .card .card-content {
        position: absolute;
        left: 0;
        color: rgb(255, 255, 255);
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(15px);
        min-height: 100%;
        width: 100%;
        transition: bottom .4s ease-in;
        box-shadow: 0 -10px 10px rgba(255, 255, 255, 0.1);
        border-top: 1px solid rgba(255, 255, 255, 0.2)
    }

    .card:hover .card-content {
        bottom: 0px
    }

    .card:hover .card-content h4,
    .card:hover .card-content h5 {
        transform: translateY(10px);
        opacity: 1
    }

    .card .card-content h4,
    .card .card-content h5 {
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 3px;
        text-align: center;
        transition: 0.8s;
        font-weight: 500;
        opacity: 0;
        transform: translateY(-40px);
        transition-delay: 0.2s
    }

    .card .card-content h5 {
        transition: 0.5s;
        font-weight: 200;
        font-size: 0.8rem;
        letter-spacing: 2px
    }

    .controller {
        position: absolute;
        /* top: 0; */
        left: 16.7%;
        bottom: 0%;
    }

    .fa-circle-play {
        font-size: 80px;
        cursor: pointer;
    }

    .fa-trash {
        font-size: 40px;
        cursor: pointer;
        color: red;
    }

    .heart {
        font-size: 40px;
        cursor: pointer;
        color: red;
    }
    .actionsRow{
        display: flex;
        justify-content: center;
        align-items: center;
        column-gap: 5px;
    }
</style>
<div class="card-slider">
    <div class="card-header">
        <h1>new song</h1>
    </div>
    <div class="card-slider-wrapper">
    @foreach ($musics as $music)
    <div class="card">
    <img src="{{ $music['img'] === '' ? asset('image/logo_music.jpg'):$music['img'] }}" alt="Avatar" style="width:100%">
        <div class="card-content">
            <h4 class="pt-2">{{ $music['title'] }}</h4>
            <h4 class="pt-2 play-button" data-url="{{ url('storage/' . $music['url']) }}"> <i class="fa-regular fa-circle-play"></i></h4>
            <h5>{{ $music['artist'] }}</h5>
            <h4>{{ $music['playtime'] }}</h4>
            <div class="actionsRow">
                <h5><a href="{{ url('deleteFile/' . $music['url']) }}"><i class="fa-solid fa-trash"></i></a></h5>
                <h5><a href="{{ url('song-like-store/' . $music['id']) }}"><i class="fa-regular fa-heart heart"></i></a></h5>
            </div>
        </div>
    </div>
@endforeach



    </div>
    <div class="card-slider-controls">
        <button class="prev">Prev</button>
        <button class="next">Next</button>
    </div>
</div>

<div class="controller">
    @include('musicController')
</div>


<script>
    const cardSlider = document.querySelector(".card-slider");
    const cardWrapper = cardSlider.querySelector(".card-slider-wrapper");
    const cards = cardSlider.querySelectorAll(".card");
    const cardWidth = cards[0].offsetWidth;
    console.log(cardWidth);
    const cardMargin = 40;
    let currentPosition = 0;

    cardWrapper.style.transform = "translateX(0)";

    document.querySelector(".next").addEventListener("click", () => {
        if (currentPosition > -(cards.length - 3) * (cardWidth + cardMargin)) {
            currentPosition -= cardWidth + cardMargin;
            cardWrapper.style.transform = `translateX(${currentPosition}px)`;
            console.log(cards.length);
        }
    });

    document.querySelector(".prev").addEventListener("click", () => {
        if (currentPosition < 0) {
            currentPosition += cardWidth + cardMargin;
            cardWrapper.style.transform = `translateX(${currentPosition}px)`;
        }
    });

    // music player 
</script>

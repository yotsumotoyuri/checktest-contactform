@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="top">
    <div class="top__mv">
        <video src="{{ asset('video/top.mp4') }}" loop autoplay muted></video>
    </div>
    <div class="top__txt">
        <h2 class="sub__ttl">about</h2>
        <h2 class="top__h2">あえて少しだけ遅れて、自分らしく。</h2>
        <p>
        FashionablyLateは、余裕を愛する人のための<br>
        ライフスタイルブランドです。
        </p>
    </div>
</div>


<div class="top__tx">
        
        <p>あえて少しだけ遅れて、自分らしく。<br>
        FashionablyLateは、余裕を愛する人のための<br>
        ライフスタイルブランドです。
        </p>
    </div>
    <div class="top__tx">
        
        <p>あえて少しだけ遅れて、自分らしく。<br>
        FashionablyLateは、余裕を愛する人のための<br>
        ライフスタイルブランドです。
        </p>
    </div>
    <div class="top__tx">
        
        <p>あえて少しだけ遅れて、自分らしく。<br>
        FashionablyLateは、余裕を愛する人のための<br>
        ライフスタイルブランドです。
        </p>
    </div>
    <div class="top__tx">
        
        <p>あえて少しだけ遅れて、自分らしく。<br>
        FashionablyLateは、余裕を愛する人のための<br>
        ライフスタイルブランドです。
        </p>
    </div>
    <div class="top__tx">
        
        <p>あえて少しだけ遅れて、自分らしく。<br>
        FashionablyLateは、余裕を愛する人のための<br>
        ライフスタイルブランドです。
        </p>
    </div>
@endsection

<script>
window.addEventListener("scroll", () => {
    const target = document.querySelector(".top");
    // スクロール量が 50px を超えたらクラスを追加
    if (window.scrollY > 50) {
        target.classList.add("is-active");
    } else {
        target.classList.remove("is-active");
    }
});
</script>
<div class="col-lg-12 media-gal isotope">

  @foreach($photos as $photo)

    <img src="{{ $photo->path }}" class="item" alt="">

  @endforeach

</div>
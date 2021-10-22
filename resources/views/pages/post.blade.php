<div class="box">
    <div class="columns">
        <div class="column is-6-desktop">
            <figure class="image">
                <img src="{{$post->post_image_url}}">
            </figure>
        </div>
        <div class="column is-6-desktop">
            <div class="content">
                <div class="content">
                    <p class="title is-5">{{$post->post_title}}</p>
                </div>
                <div class="content">
                    {!!$post->post_content!!}
                </div>
                @if($post->post_category_id != 5)
                <div id="disqus_thread"></div>
                @endif
            </div>
        </div>
    </div>
</div>
@if($post->post_category_id != 5)
<script>

/**
*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
/*
var disqus_config = function () {
this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};
*/
(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');
s.src = 'https://cahayaagro.disqus.com/embed.js';
s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();

$(document).ready(function  () {
    back('home');
});
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
@endif
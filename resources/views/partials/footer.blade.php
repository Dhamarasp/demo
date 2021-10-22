    @php
        $setting = \App\Models\Setting::select('setting_id', 'setting_content')->whereBetween('setting_id', [6, 15])->get();
    @endphp
    <section class="section" style="background: linear-gradient(to bottom right, #033298, #3d76f1); ">
        <div class="columns">
            <div class="column notification is-black" style="background: transparent;">
                <div class="content has-text-centered">
                    <figure class="image">
                        <img src="{{asset('images/5aec7db8b4f33275045784.jpg')}}" style="height: 80px; width: 200px;">
                    </figure>
                    <p class="title">
                        <b>PT JATIM GRHA UTAMA</b>
                    </p>
                </div>
            </div>
            <div class="column notification is-black" style="background: transparent;">
                <div class="content">
                    <p>
                        {{$setting->where('setting_id', 14)->first()->setting_content}}
                    </p>
                </div>
                <iframe src="{{$setting->where('setting_id', 15)->first()->setting_content}}"
                    width="275" height="225" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
            <div class="column notification is-black" style="background: transparent;">
                <div class="content">
                    <dt>
                        <dl>
                            <b>Phone</b>: {{$setting->where('setting_id', 11)->first()->setting_content}}</dl>
                        <dl>
                            <b>Email</b>: <a href="mailto:{{$setting->where('setting_id', 12)->first()->setting_content}}">{{$setting->where('setting_id', 12)->first()->setting_content}}</a></dl>
                        <dl>
                            <b>Fax</b>: {{$setting->where('setting_id', 13)->first()->setting_content}}</dl>
                    </dt>
                    <div style="font-size: 2rem; margin-top: 1.5rem;">
                        <a href="{{$setting->where('setting_id', 6)->first()->setting_content}}" style="text-decoration: none;">
                            <span class="icon has-text-info" style="width: 2.4rem; height: 2.4rem;">
                                <i class="fa fa-twitter" style="color:white"></i>
                            </span>
                        </a>
                        <a href="{{$setting->where('setting_id', 7)->first()->setting_content}}" style="text-decoration: none;">
                            <span class="icon has-text-info" style="width: 2.4rem; height: 2.4rem;">
                                <i class="fa fa-facebook" style="color:white"></i>
                            </span>
                        </a>
                        <a href="{{$setting->where('setting_id', 8)->first()->setting_content}}" style="text-decoration: none;">
                            <span class="icon has-text-info" style="width: 2.4rem; height: 2.4rem;">
                                <i class="fa fa-instagram" style="color:white"></i>
                            </span>
                        </a>
                        <a href="{{$setting->where('setting_id', 9)->first()->setting_content}}" style="text-decoration: none;">
                            <span class="icon has-text-info" style="width: 2.4rem; height: 2.4rem;">
                                <i class="fa fa-youtube-play" style="color:white"></i>
                            </span>
                        </a>
                        <a href="{{$setting->where('setting_id', 10)->first()->setting_content}}" style="text-decoration: none;">
                            <span class="icon has-text-info" style="width: 2.4rem; height: 2.4rem;">
                                <i class="fa fa-linkedin-square" style="color:white"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="tile is-parent" style="background: transparent;">
            <div class="tile is-child notification is-black has-text-centered" style="background: transparent;">
                <p>
                    Powered by
                    <a href="https://www.mataduniadigital.com">
                        <b>Mataduniadigital</b>
                    </a>@2018
                </p>
            </div>
        </div>
    </section>
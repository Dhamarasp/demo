<section class="hero is-fullheight is-primary-color">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="columns">
                <div class="column is-6" style="margin: auto;">
                    <div class="box">
                        <h3 class="title has-text-grey">Login</h3>
                        <p class="subtitle has-text-grey">Silakan login untuk melanjutkan.</p>
                        <figure>
                            <img src="{{asset('images/5af0169b2c147686411668.png')}}" width="84" height="84">
                        </figure>
                        <div class="is-gap">
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="email" placeholder="user@mail.com" name="email" required>
                                </div>
                            </div>
                            <div class="field has-addons">
                                <div class="control width-100">
                                    <input class="input" type="password" placeholder="password" name="password" required>
                                </div>
                                <div class="control">
                                    <a class="button">
                                        <span class="icon is-medium is-right" onclick="tooglePassword(this)">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control width-100">
                                    <button class="button is-black is-primary-color width-100" onclick="signinAction()">Login</button>
                                </div>
                            </div>
                        </div>
                        <div class="is-gap">
                            <p class="has-text-grey">
                                <a class="target-link" href="#signup">Daftar</a> &nbsp;·&nbsp;
                                <a class="target-link" href="#forgot-password">Lupa Password</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function (){
        hideBack();
    });

    function signinAction(){
        $.ajax({
            type: 'POST',
            url: base_url + 'signin',
            async: false,
            data: {
                email: $('input[name=email]').val(),
                password: $('input[name=password]').val()
            },
            success: function (result) {
                if(result.status == 200){
                    iziToast.success({ title: 'OK', message: result.message });
                    // var original_title = location.hash;
                    // var target_url = original_title.replace('#','');
                    // loadURI(target_url);
                    location.reload();
                }else if(result.status == 201){
                    iziToast.warning({ title: 'Oops', message: result.message });
                }else{
                    console.log(result);
                }
            }
        });
    }

    function tooglePassword(el){

        $(el).find('i').toggleClass("fa-eye fa-eye-slash");
        var input = $('input[name=password]');
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    }
</script>
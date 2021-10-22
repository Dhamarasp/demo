<section class="hero is-fullheight is-primary-color">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="columns">
                <div class="column is-6" style="margin: auto;">
                    <div class="box">
                        <h3 class="title has-text-grey">Daftar</h3>
                        <p class="subtitle has-text-grey">Silakan Kamu daftar sebelum login.</p>
                        <figure>
                            <img src="{{asset('images/5af0169b2c147686411668.png')}}" width="84" height="84">
                        </figure>
                        <div class="is-gap">
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="email" placeholder="your email" name="email" required>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="password" placeholder="make your password" name="password" required>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="password" placeholder="confirm your password" name="confirm_password" required>
                                </div>
                            </div>
                            <div class="field">
                                <label class="checkbox">
                                    <input type="checkbox" name="terms">Saya setuju dengan <a class="target-link" href="#post/7">syarat dan ketentuan</a>
                                </label>
                            </div>
                            <div class="field">
                                <div class="control width-100">
                                    <button class="button is-black is-primary-color width-100" onclick="signupAction(this)">Daftar</button>
                                </div>
                            </div>
                        </div>
                        <div class="is-gap">
                            <p class="has-text-grey">
                                Apa Kamu punya akun? <a class="target-link" href="#account">Login</a>
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

    function signupAction(element){
        var item = $(element);
        if($('input[name=terms]').is(':checked')) {
            item.addClass('is-loading');
            $.ajax({
                type: 'POST',
                url: base_url + 'signup',
                async: false,
                data: {
                    email: $('input[name=email]').val(),
                    password: $('input[name=password]').val(),
                    confirm_password: $('input[name=confirm_password]').val()
                },
                success: function (result) {
                    item.removeClass('is-loading');
                    if(result.status == 200){
                        ga("gtag_UA_107066470_1.send", {
                            hitType: 'event',
                            eventAction: 'click',
                            eventCategory: 'Email Registration',
                            eventLabel: 'email-registration'
                        });
                        iziToast.success({ title: 'OK', message: result.message });
                        loadURI('account');
                    }else if(result.status == 201){
                        iziToast.warning({ title: 'Oops', message: result.message });
                    }else{
                        console.log(result);
                    }
                }
            });
        }else{
            iziToast.warning({ title: 'Oops', message: 'Please check and agree with our terms and condition' });
        }
    }
</script>
<section class="hero is-fullheight is-primary-color">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="columns">
                <div class="column is-6" style="margin: auto;">
                    <div class="box">
                        <h3 class="title has-text-grey">Lupa Password</h3>
                        <p class="subtitle has-text-grey">Masukkan email Kamu di bawah.</p>
                        <figure>
                            <img src="{{asset('images/5af0169b2c147686411668.png')}}" width="84" height="84">
                        </figure>
                        <div class="is-gap">
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="email" placeholder="user@mail.com" name="email" required>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control width-100">
                                    <button class="button is-black is-primary-color width-100" onclick="forgotPasswordAction()">Submit</button>
                                </div>
                            </div>
                        </div>
                        <div class="is-gap">
                            <p class="has-text-grey">
                                <a class="target-link" href="#account">Login</a> &nbsp;·&nbsp;
                                <a class="target-link" href="#signup">Daftar</a>
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

    function forgotPasswordAction(){
        $.ajax({
            type: 'POST',
            url: base_url + 'forgot-password',
            async: false,
            data: {
                email: $('input[name=email]').val()
            },
            success: function (result) {
                if(result.status == 200){
                    iziToast.success({ title: 'OK', message: result.message });
                }else if(result.status == 201){
                    iziToast.warning({ title: 'Oops', message: result.message });
                }else{
                    console.log(result);
                }
            }
        });
    }
</script>
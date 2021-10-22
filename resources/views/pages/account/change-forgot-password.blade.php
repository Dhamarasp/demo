<section class="hero is-fullheight is-primary-color">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="columns">
                <div class="column is-6" style="margin: auto;">
                    <div class="box">
                        <h3 class="title has-text-grey">Lupa Password</h3>
                        <p class="subtitle has-text-grey">Buat password baru Kamu.</p>
                        <figure>
                            <img src="{{asset('images/5af0169b2c147686411668.png')}}" width="84" height="84">
                        </figure>
                        <div class="is-gap">
                            <div class="field">
                                <label class="label">Password baru</label>
                                <div class="control">
                                    <input class="input" type="password" name="new_password" placeholder="******">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Ketikan kembali password baru</label>
                                <div class="control">
                                    <input class="input" type="password" name="confirm_new_password" placeholder="******">
                                </div>
                            </div>
                            <div class="field">
                                <div class="control width-100">
                                    <button class="button is-black is-primary-color width-100" onclick="newPasswordAction()">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function  () {
        hideBack();
    });

    function newPasswordAction(){
        $.ajax({
            type: 'POST',
            url: base_url + 'forgot-password/{{$email}}/{{$key}}',
            async: false,
            data: {
                new_password: $('input[name=new_password]').val(),
                confirm_new_password: $('input[name=confirm_new_password]').val()
            },
            success: function (result) {
                if(result.status == 200){
                    iziToast.success({ title: 'OK', message: result.message });
                    loadURI('account');
                }else if(result.status == 201){
                    iziToast.warning({ title: 'Oops', message: result.message });
                }else{
                    console.log(result);
                }
            }
        });
    }
</script>
<div class="content has-text-centered" style="margin-top: 1rem;">
    <p class="title is-5">Ubah Password</p>
</div>
<div class="box">
    <div class="field">
        <label class="label">Password lama</label>
        <div class="control">
            <input class="input" type="password" name="old_password" placeholder="******">
        </div>
    </div>
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

    <div class="field is-grouped">
        <div class="control width-100">
            <button class="button is-danger is-primary-color width-100" onclick="changePasswordAction()">Simpan</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function  () {
        back('account');
    });

    function changePasswordAction(){
        // console.log('hello');
        $.ajax({
            type: 'POST',
            url: base_url + 'account/password/change',
            async: false,
            data: {
                old_password: $('input[name=old_password]').val(),
                new_password: $('input[name=new_password]').val(),
                confirm_new_password: $('input[name=confirm_new_password]').val()
            },
            success: function (result) {
                if(result.status == 200){
                    iziToast.success({ title: 'OK', message: result.message });
                    $('input[name="old_password"]').val('');
                    $('input[name="new_password"]').val('');
                    $('input[name="confirm_new_password"]').val('');
                }else if(result.status == 201){
                    iziToast.warning({ title: 'Oops', message: result.message });
                }else{
                    console.log(result);
                }
            }
        });
    }
</script>
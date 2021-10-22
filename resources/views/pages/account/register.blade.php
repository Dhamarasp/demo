@if($customer->customer_status == 0)
<div class="content has-text-centered is-gap">
    <p class="title is-5">Mohon cek dan konfirmasi email Kamu sebelum melanjutkan</p>
</div>
<div class="content has-text-centered">
    <p class="subtitle is-5">Akun Kamu telah dibuat, kami mengirimkan email konfirmasi ke email yang Kamu daftarkan untuk memverifikasi bahwa email yang Kamu daftarkan benar-benar milik Kamu</p>
</div>
<div id="action" class="content has-text-centered" style="display:block;">
    <p class="subtitle is-5">Kamu belum menerima konfirmasi email?</p>
    <div class="field">
        <div class="control width-100">
            <button class="button is-danger is-primary-color width-100" onclick="resendAction()">Kirim ulang email</button>
        </div>
    </div>
</div>
<div id="await" class="content has-text-centered" style="display:none;">
    <p id="await-text" class="subtitle is-5 has-text-danger	">Tunggu xx detik untuk mengirim kembali</p>
</div>
<div class="content has-text-centered">
    <p class="subtitle is-5">Oops, kamu salah memasukkan email? Klik logout untuk keluar dan daftar ulang kembali</p>
    <div class="field">
        <div class="control width-100">
            <button class="button is-danger is-primary-color width-100" onclick="signoutAction()">Logout</button>
        </div>
    </div>
</div>
<script>
    $(document).ready(function (){
        hideBack();
    });
    
    function resendAction(){
        var timeout = 30;
        ajaxPostRequest('account/resend-activation', function(result){
            if(result.status == 200){
                iziToast.success({ title: 'OK', message: result.message });
                $('#action').hide();
                $('#await').show();
                setTimeout(function(){
                    $('#action').show();
                    $('#await').hide();
                }, 30000);
                setInterval(function(){ 
                    var i = timeout--;
                    if(timeout > 0){
                        $('#await-text').html('Tunggu ' +i+ ' detik untuk mengirim kembali');
                    } else {
                        return false;
                    }
                    
                }, 1000);
            }
        }, {
        });
    }

    function signoutAction(){
        ajaxPostRequest('account/signout', function(result){
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
        });
    }
</script>
@elseif($customer->customer_status == 1)
<div class="content has-text-centered is-gap">
    <p class="title is-5">Mohon lengkapi form pendaftaran berikut agar memudahkan kami saat melakukan pengiriman</p>
</div>
<div class="box">
    <div class="field">
        <label class="label">Nama Kamu*</label>
        <div class="control">
            <input class="input" type="text" name="customer_name">
        </div>
    </div>
    <div class="field">
        <label class="label">Telepon Kamu*</label>
        <div class="control">
            <input class="input" type="text" name="customer_phone">
        </div>
    </div>
    <div class="field">
        <label class="label">Tanggal Lahir*</label>
        <div class="control">
            <input class="input" type="text" name="customer_birthday" id="customer_birthday">
        </div>
    </div>
    <div class="field">
        <label class="label">Gender*</label>
        <div class="control">
            <div class="select width-100">
                <select class="width-100" name="customer_gender">
                    <option value="">Pilih gender</option>
                    <option value="1">Laki-laki</option>
                    <option value="2">Perempuan</option>
                </select>
            </div>
        </div>
    </div>
    <div class="field">
        <label class="label">Alamat Domisili*</label>
        <textarea class="textarea" placeholder="Alamat Domisili" name="customer_address"></textarea>
    </div>
    <div class="field">
        <label class="label">Bisnis Kamu (opsional)</label>
        <div class="control">
            <input class="input" type="text" placeholder="Perusahaan / Badan usaha"name="customer_institution">
        </div>
    </div>
    
    <div class="field">
        <div class="control width-100">
            <button class="button is-danger is-primary-color  width-100" onclick="registerAction()">Simpan</button>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('vendor/bulma-calendar/dist/datepicker.min.js')}}"></script>
<script>
    $(document).ready(function (){
        hideBack();
        var customer_birthday = new DatePicker(document.getElementById('customer_birthday'), {
            overlay: true,
            dataFormat: "yyyy-mm-dd",
            startDate: new Date(1990, 1, 1)
        });
    });

    function registerAction(){
        ajaxPostRequest('account/register', function(result){
            if(result.status == 200){
                ga("gtag_UA_107066470_1.send", {
                    hitType: 'event',
                    eventAction: 'click',
                    eventCategory: 'Completed Registration',
                    eventLabel: 'completed-registration'
                });
                iziToast.success({ title: 'OK', message: result.message });
                var original_title = location.hash;
                var target_url = original_title.replace('#','');
                loadURI(target_url);
            }else if(result.status == 201){
                iziToast.warning({ title: 'Oops', message: result.message });
            }else{
                console.log(result);
            }
        }, {
            customer_name: $('input[name=customer_name]').val(),
            customer_phone: $('input[name=customer_phone]').val(),
            customer_birthday: $('input[name=customer_birthday]').val(),
            customer_gender: $('select[name=customer_gender]').val(),
            customer_address: $('textarea[name=customer_address]').val(),
            customer_institution: $('input[name=customer_institution]').val()
        });
    }
</script>
@endif
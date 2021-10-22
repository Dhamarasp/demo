<div class="content has-text-centered is-gap">
    <p class="title is-5">Edit Profile</p>
</div>
<div class="box">
    <div class="field">
        <label class="label">Nama Kamu*</label>
        <div class="control">
            <input class="input" type="text" name="customer_name" value="{{$customer->customer_name}}">
        </div>
    </div>
    <div class="field">
        <label class="label">Tanggal Lahir*</label>
        <div class="control">
            <input class="input" type="text" name="customer_birthday" id="customer_birthday" value="{{ date_format(date_create($customer->customer_birthday),'Y-m-d')}}">
        </div>
    </div>
    <div class="field">
        <label class="label">Gender*</label>
        <div class="control">
            <div class="select width-100">
                <select class="width-100" name="customer_gender">
                    <option value="">Pilih gender</option>
                    <option value="1" @if($customer->customer_gender == 1) selected @endif >Laki-laki</option>
                    <option value="2" @if($customer->customer_gender == 2) selected @endif >Perempuan</option>
                </select>
            </div>
        </div>
    </div>
    <div class="field">
        <label class="label">Alamat Domisili*</label>
        <textarea class="textarea" placeholder="Alamat Domisili" name="customer_address">{{$customer->customer_address}}</textarea>
    </div>
    <div class="field">
        <label class="label">Bisnis Kamu (opsional)</label>
        <div class="control">
            <input class="input" type="text" placeholder="Perusahaan / Badan usaha" name="customer_institution" value="{{$customer->customer_institution}}">
        </div>
    </div>
    
    <div class="field">
        <div class="control width-100">
            <button class="button is-danger is-primary-color  width-100" onclick="saveAction()">Simpan</button>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('vendor/bulma-calendar/dist/datepicker.min.js')}}"></script>
<script>
    $(document).ready(function (){
        back('account');
        var customer_birthday = new DatePicker(document.getElementById('customer_birthday'), {
            overlay: true,
            dataFormat: "yyyy-mm-dd",
            startDate: new Date(1990, 1, 1)
        });
    });

    function saveAction(){
        ajaxPostRequest('account/edit', function(result){
            if(result.status == 200){
                iziToast.success({ title: 'OK', message: result.message });
                loadURI('account');
            }else if(result.status == 201){
                iziToast.warning({ title: 'Oops', message: result.message });
            }else{
                console.log(result);
            }
        }, {
            customer_name: $('input[name=customer_name]').val(),
            customer_birthday: $('input[name=customer_birthday]').val(),
            customer_gender: $('select[name=customer_gender]').val(),
            customer_address: $('textarea[name=customer_address]').val(),
            customer_institution: $('input[name=customer_institution]').val()
        });
    }
</script>
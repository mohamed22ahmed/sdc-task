
<div>
    <h1>A new brand has requested to join</h1>
    <span style="font-size:18px">English User Name :</span>
    <span style="font-size:15px">{{ $data['name'] }}</span><br>
    <span style="font-size:18px">Arabic User Name :</span>
    <span style="font-size:15px">{{ $data['name_ar']??'-' }}</span><br><br>

    <span style="font-size:18px">User Email:</span>
    <span style="font-size:15px">{{ $data['email'] }}</span><br><br>

    <span style="font-size:18px">English Brand Name :</span>
    <span style="font-size:15px">{{ $data['brand_name'] }}</span><br>
    <span style="font-size:18px">Arabic Brand Name :</span>
    <span style="font-size:15px">{{ $data['brand_name_ar']??'-' }}</span><br><br>
</div>

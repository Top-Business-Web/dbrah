<form id="updateForm" method="POST" enctype="multipart/form-data" action="{{route('categories.update',$category->id)}}">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name" class="form-control-label">الصورة</label>
        <input type="file" id="testDrop" class="dropify" name="image" data-default-file="{{$category->image}}"/>
    </div>
    <div class="form-group">
        <label for="title_ar" class="form-control-label">العنوان باللغة العربية</label>
        <input type="text" class="form-control" name="title_ar" value="{{$category->title_ar}}">
    </div>
    <div class="form-group">
        <label for="title_en" class="form-control-label">العنوان باللغة الانجليزية</label>
        <input type="text" class="form-control" name="title_en" value="{{$category->title_en}}">
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
        <button type="submit" class="btn btn-success" id="updateButton">تعديل</button>
    </div>
</form>

<form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{route('nationalities.store')}}">
    @csrf

    {{-- <div class="form-group">
        <label for="name" class="form-control-label">الصورة</label>
        <input type="file" class="dropify" name="image" data-default-file="{{asset('fav.png')}}" accept="image/png, image/svg, image/gif, image/jpeg,image/jpg"/>
        <span class="form-text text-danger text-center">مسموح فقط بالصيغ التالية : png, gif, jpeg, jpg</span>
    </div> --}}
    <div class="form-group">
        <label for="from" class="form-control-label">وقت الإبتداء</label>
        <input type="time" class="form-control" name="from" id="start_time"  value="{{$nationality->from}}">
    </div>
    <div class="form-group">
        <label for="to" class="form-control-label">وقت الانتهاء</label>
        <input type="time" class="form-control" name="to" id="end_time" value="{{$nationality->to}}">
        <span class="form-text text-danger text-center" id="timeError" style="display:none;">وقت الانتهاء يجب أن يكون بعد وقت الإبتداء</span>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
        <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
    </div>
    <script>
        document.getElementById('addForm').addEventListener('submit', function(e) {
            var start = document.getElementById('start_time').value;
            var end = document.getElementById('end_time').value;
            // Convert to integer hours only
            var startHour = start ? parseInt(start.split(':')[0], 10) : null;
            var endHour = end ? parseInt(end.split(':')[0], 10) : null;
            if (startHour !== null && endHour !== null && startHour >= endHour) {
                e.preventDefault();
                document.getElementById('timeError').style.display = 'block';
            } else {
                document.getElementById('timeError').style.display = 'none';
            }
        });
    </script>
</form>
<script>
    $('.dropify').dropify()
</script>


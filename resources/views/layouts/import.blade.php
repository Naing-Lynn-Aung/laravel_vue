<form action="{{ route('post.import') }}" method="POST" enctype="multipart/form-data" class="form-width">
  @csrf
  <h2 class="">Upload CSV File</h2>
  <input type="file" name="import" class="mt-5 mb-2 form-control" >

  <button type="submit" class="btn btn-color mt-5">Import File</button>
</form>

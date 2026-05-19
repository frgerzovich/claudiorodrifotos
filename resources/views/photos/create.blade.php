<form action="{{ route('photos.store') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <input type="text"
           name="title"
           placeholder="Título">

    <textarea name="description"></textarea>

    <input type="number"
           step="0.01"
           name="price"
           placeholder="Precio">

    <select name="album_id">

        <option value="">
            Sin álbum (pública)
        </option>

        @foreach($albums as $album)

            <option value="{{ $album->id }}">
                {{ $album->title }}
            </option>

        @endforeach

    </select>

    <input type="file" name="image">

    <button type="submit">
        Subir foto
    </button>

</form>
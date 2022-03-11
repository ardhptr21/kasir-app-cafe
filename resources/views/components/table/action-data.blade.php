<div class="flex gap-2">
    @if ($withDetail)
        <a href="{{ $detailAction }}">
            <button class="flex items-center justify-center p-2 text-white rounded-md bg-sky-500">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </button>
        </a>
    @endif
    @if ($withEdit)
        <a href="{{ $editAction }}">
            <button class="flex items-center justify-center p-2 text-white bg-yellow-500 rounded-md">
                <i class="fa-solid fa-pen-to-square"></i>
            </button>
        </a>
    @endif
    <form action="{{ $removeAction }}" method="POST" x-data="{}" x-ref="form">
        @csrf
        @method('DELETE')
        <button @click.prevent="if(confirm('Yakin ingin menghapus')) $refs.form.submit()" type="submit"
            class="flex items-center justify-center p-2 text-white bg-red-500 rounded-md">
            <i class="fa-solid fa-dumpster-fire"></i>
        </button>
    </form>
</div>

<form action="{{ route('language.change') }}" method="POST">
    @csrf
    <select name="locale" onchange="this.form.submit()"
        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 pr-10">
        <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>
        <option value="th" {{ session()->get('locale') == 'th' ? 'selected' : '' }}>Thai</option>
        <option value="lo" {{ session()->get('locale') == 'lo' ? 'selected' : '' }}>Laos</option>
    </select>
</form>

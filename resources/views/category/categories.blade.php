@extends('layouts.dashboard')

@section('content')
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        slug
                    </th>
                    <th scope="col" class="px-6 py-3">
                        description
                    </th>

                    <th scope="col" class="px-6 py-3">
                        actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <a href="{{ route('post.show', [$category->id]) }} " class="hover:bg-green-400">
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-200">

                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <a href="{{ route('post.show', [$category->id]) }} ">

                                    {{ $category->name }}
                                </a>

                            </th>
                            <td class="px-6 py-4">
                                {{ $category->slug }}
                            </td>
                            
                            <td class="px-6 py-4">
                                {{ $category->description }}
                            </td>
                            <td class="px-6 py-4 flex ">
                                <a href="{{ route('category.delete', [$category->id]) }}"
                                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">delete</a>
                                <a href="{{ route('category.edit', [$category->id]) }} "
                                    class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">edit</a>
                            </td>
                        </tr>
                @endforeach


            </tbody>
        </table>
        <div class="pagination my-2">
            {{ $categories->links() }}
        </div>

    </div>
@endsection




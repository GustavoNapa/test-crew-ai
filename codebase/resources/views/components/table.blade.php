<table {!! $attributes->merge(['class' => 'table-auto w-full border-collapse border border-slate-300 dark:border-slate-600 text-gray-800 dark:text-gray-200']) !!}>
    <thead>
        <tr class="text-left border-b border-slate-400 dark:border-slate-500 bg-gray-200 dark:bg-gray-700">
            {{$thead}}
        </tr>
    </thead>
    <tbody>
        <tr {!! $attributes->merge(['class' => 'odd:bg-white odd:dark:bg-gray-900 even:bg-gray-100 even:dark:bg-gray-800 border-b border-gray-300 dark:border-gray-600 hover:bg-gray-200 cursor-pointer hover:dark:bg-gray-700']) !!}>
            {{$tbody}}
        </tr>
    </tbody>
</table>
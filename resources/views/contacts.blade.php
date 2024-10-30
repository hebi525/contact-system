<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>


        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" />
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="p-4">
                <div class="flex gap-2 justify-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContactModal">Add Contact</button>
                    <!-- <input type="text" placeholder="Search" id="searchBar"> -->
                </div>
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>name</th>
                        <th>company</th>
                        <th>phone</th>
                        <th>email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->name }}</td>
                        <td>{{ $post->company }}</td>
                        <td>{{ $post->phone }}</td>
                        <td>{{ $post->email }}</td>
                        <td>
                            <div class="flex gap-2">
                                <button class="btn btn-primary updateButton" data-contact-id="{{ $post->id }}" data-contact-data="{{ $post }}">Edit</button>
                                <button class="btn btn-primary deleteButton" data-contact-id="{{ $post->id }}">Delete</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </main>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-body">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure you want to delete?</h1>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <form method="POST" action="{{ route('contacts.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="deleteContactId" name="id" value="">
                    <button type="submit" class="btn btn-primary">Yes</button>
                </form>
            </div>
            </div>
        </div>
        </div>

        <!-- Add Contact Modal -->
        <div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('contacts.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Contact</h1>
                        <div class="flex flex-col gap-2">
                            <div class="flex gap-4 justify-center items-center">
                                <div class="">name</div>
                                <input type="text" name="name">
                            </div>
                            <div class="flex gap-4 justify-center items-center">
                                <div class="">company</div>
                                <input type="text" name="company">
                            </div>
                            <div class="flex gap-4 justify-center items-center">
                                <div class="">phone</div>
                                <input type="text" name="phone">
                            </div>
                            <div class="flex gap-4 justify-center items-center">
                                <div class="">email</div>
                                <input type="text" name="email">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
        </div>

        <!-- Update Contact Modal -->
        <div class="modal fade" id="updateContactModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="updateContactForm" action="{{ route('contacts.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="updateContactId" name="id" value="">
                    <div class="modal-body">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Contact</h1>
                        <div class="flex flex-col gap-2">
                            <div class="flex gap-4 justify-center items-center">
                                <div class="">name</div>
                                <input type="text" name="name">
                            </div>
                            <div class="flex gap-4 justify-center items-center">
                                <div class="">company</div>
                                <input type="text" name="company">
                            </div>
                            <div class="flex gap-4 justify-center items-center">
                                <div class="">phone</div>
                                <input type="text" name="phone">
                            </div>
                            <div class="flex gap-4 justify-center items-center">
                                <div class="">email</div>
                                <input type="text" name="email">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
            var myTable = $('#myTable').DataTable({searching: true, paging: true, info: true});
        })

        $('.deleteButton').click(function(){
            $('#deleteContactId').val($(this).data('contact-id'));
            $('#exampleModal').modal('show');
        })

        $('.updateButton').click(function(){
            let data = $(this).data('contact-data');
            $('#updateContactId').val($(this).data('contact-id'));
            $('#updateContactForm').find('input[name=name]').val(data.name);
            $('#updateContactForm').find('input[name=company]').val(data.company);
            $('#updateContactForm').find('input[name=phone]').val(data.phone);
            $('#updateContactForm').find('input[name=email]').val(data.email);
            $('#updateContactModal').modal('show');
        })

    </script>
</html>

@extends('adminLayout')


@section('main')
    <div class="iq-navbar-header" style="height: 215px;">
        <div class="container-fluid iq-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="flex-wrap d-flex justify-content-between align-items-center">
                        <div>
                            <h1>{{ __('dashboard.orderDetials') }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="iq-header-img">
            <img src="{{ asset('Admin/assets/images/dashboard/top-header.png') }}" alt="header"
                class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
            <img src="{{ asset('Admin/assets/images/dashboard/top-header1.png') }}" alt="header"
                class="theme-color-purple-img img-fluid w-100 h-100 animated-scaleX">
            <img src="{{ asset('Admin/assets/images/dashboard/top-header2.png') }}" alt="header"
                class="theme-color-blue-img img-fluid w-100 h-100 animated-scaleX">
            <img src="{{ asset('Admin/assets/images/dashboard/top-header3.png') }}" alt="header"
                class="theme-color-green-img img-fluid w-100 h-100 animated-scaleX">
            <img src="{{ asset('Admin/assets/images/dashboard/top-header4.png') }}" alt="header"
                class="theme-color-yellow-img img-fluid w-100 h-100 animated-scaleX">
            <img src="{{ asset('Admin/assets/images/dashboard/top-header5.png') }}" alt="header"
                class="theme-color-pink-img img-fluid w-100 h-100 animated-scaleX">
        </div>
    </div>
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-inline justify-content-center">
                            <div class="d-flex mb-4">
                                <div class="d-inline flex-fill p-4 justify-content-between flex-wrap">
                                    <div class="mb-3 alert alert-left alert-success alert-dismissible fade show" role="alert">
                                        <span>{{ __('dashboard.messages') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('partials._session')
                        @include('partials._errors')
                        <div class="card-body px-0">
                            <div class="table-responsive">
                                <table id="user-list-table" class="table table-striped" role="grid"
                                    data-toggle="data-table">
                                    <thead>
                                        <tr class="ligth">
                                            <th>#</th>
                                            <th>{{ __('dashboard.Sendermember') }}</th>
                                            <th>{{ __('dashboard.recipientmember') }}</th>
                                            <th style="min-width: 300px">{{ __('dashboard.subjecet') }}</th>
                                            <th>{{ __('dashboard.date') }}</th>
                                            <th style="min-width: 100px">{{ __('dashboard.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($messages as $message)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td><a onclick="getUserData(this, '{{ $message->user_id }}')"
                                                        href="#senderModel" data-bs-toggle="modal" data-placement="top"
                                                        title="sender"
                                                        data-original-title="sender">{{ $message->sender }}</a></td>
                                                <td><a onclick="getUserData(this, '{{ $message->seller_id }}')"
                                                        href="#senderModel" data-bs-toggle="modal" data-placement="top"
                                                        title="reception"
                                                        data-original-title="recipient">{{ $message->recipientName }}</a>
                                                </td>
                                                <td style="white-space: pre-wrap;">
                                                    @if ($message->type == 'reply')
                                                        {{ __('dashboard.reply') }}
                                                    @endif
                                                    {{ $message->message }}
                                                </td>
                                                <td>{{ $message->time }}</td>
                                                <td>
                                                    <div class="flex align-items-center list-user-action">
                                                        <a class="btn btn-sm btn-icon btn-danger" data-bs-toggle="modal"
                                                            data-placement="top" title="" data-original-title="Delete"
                                                            onclick="myFunction(this, '{{ $message->id }}' ,'delete')"
                                                            href="#deleteModal">
                                                            <span class="btn-inner">
                                                                <svg width="20" viewBox="0 0 24 24" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    stroke="currentColor">
                                                                    <path
                                                                        d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                    </path>
                                                                    <path d="M20.708 6.23975H3.75" stroke="currentColor"
                                                                        stroke-width="1.5" stroke-linecap="round"
                                                                        stroke-linejoin="round"></path>
                                                                    <path
                                                                        d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                    </path>
                                                                </svg>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="senderModel" tabindex="-1" aria-labelledby="senderModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="senderModel">{{ __('dashboard.userDetials') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.#') }}</label>
                                <input class="form-control" id="id" type="text" readonly>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.name') }}</label>
                                <input class="form-control" id="name" readonly>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.email') }}</label>
                                <input class="form-control" id="email" readonly>
                            </div>
                            <div class="form-group">
                                <label for="validationTextarea" class="form-label">{{ __('dashboard.phone') }}</label>
                                <input class="form-control" id="phone" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModal">{{ __('dashboard.deleteMessage') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <form id="delete-form" class="was-validated" action="{{ route('message.delete') }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <input id="messageIdDelete" name="messageId" type="hidden" class="form-control">
                        </form>
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('dashboard.close') }}</button>
                        <button form="delete-form" type="submit"
                            class="btn btn-primary">{{ __('dashboard.delete') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function myFunction(e, id, type = "") {
                if (type == "delete") {
                    const e = document.getElementById('messageIdDelete');
                    if (e) e.value = id;
                }
            }

            function getUserData(e, id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
                if (id) {
                    $.post("/messages/getData", {
                        "user_id": id,
                    }, function(data, status, xhr) {
                        data = JSON.parse(data)
                        document.getElementById("id").value = data.id;
                        document.getElementById("name").value = data.name;
                        document.getElementById("email").value = data.email;
                        document.getElementById("phone").value = data.phone;
                    })
                }
            }
        </script>
    @endsection

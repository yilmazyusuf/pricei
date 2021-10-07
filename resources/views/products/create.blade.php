@extends('layouts.index')
@section('meta.title', 'Add Product')
@section('content')
    <div class="main-content-wrap sidenav-open d-flex flex-column">
        <!-- ============ Body content start ============= -->
        <div class="main-content">
            <div class="breadcrumb justify-content-between align-items-center" style="flex-direction: row">
                <h1 class="mr-2">Add Product</h1>

            </div>
            <div class="separator-breadcrumb border-top"></div>
            <div class="row">
                <div class="col-lg-12 col-md-6 col-sm-6">
                    <ul class="nav nav-pills" id="myIconTab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="home-icon-tab" data-toggle="tab" href="#homeIcon" role="tab" aria-controls="homeIcon" aria-selected="true"><i class="nav-icon i-Home1 mr-1"></i>Detail</a></li>
                        <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#profileIcon" role="tab" aria-controls="profileIcon" aria-selected="false"><i class="nav-icon i-Home1 mr-1"></i> Profile</a></li>
                        <li class="nav-item"><a class="nav-link" id="contact-icon-tab" data-toggle="tab" href="#contactIcon" role="tab" aria-controls="contactIcon" aria-selected="false"><i class="nav-icon i-Home1 mr-1"></i> Contact</a></li>
                    </ul>
                    <div class="tab-content px-0" id="myIconTabContent">
                        <div class="tab-pane fade show active" id="homeIcon" role="tabpanel" aria-labelledby="home-icon-tab">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <form>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="inputEmail3">Email</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" id="inputEmail3" type="email" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="inputPassword3">Password</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" id="inputPassword3" type="password" placeholder="Password">
                                            </div>
                                        </div>
                                        <fieldset class="form-group">
                                            <div class="row">
                                                <div class="col-form-label col-sm-2 pt-0">Radios</div>
                                                <div class="col-sm-10">
                                                    <div class="form-check">
                                                        <input class="form-check-input" id="gridRadios1" type="radio" name="gridRadios" value="option1" checked="checked">
                                                        <label class="form-check-label ml-3" for="gridRadios1">
                                                            First radio

                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" id="gridRadios2" type="radio" name="gridRadios" value="option2">
                                                        <label class="form-check-label ml-3" for="gridRadios2">
                                                            Second radio

                                                        </label>
                                                    </div>
                                                    <div class="form-check disabled">
                                                        <input class="form-check-input" id="gridRadios3" type="radio" name="gridRadios" value="option3" disabled="disabled">
                                                        <label class="form-check-label ml-3" for="gridRadios3">
                                                            Third disabled radio

                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <div class="form-group row">
                                            <div class="col-sm-2">Checkbox</div>
                                            <div class="col-sm-10">
                                                <div class="form-check">
                                                    <input class="form-check-input" id="gridCheck1" type="checkbox">
                                                    <label class="form-check-label ml-3" for="gridCheck1">
                                                        Example checkbox

                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <button class="btn btn-primary" type="submit">Sign in</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profileIcon" role="tabpanel" aria-labelledby="profile-icon-tab">
                            Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore.

                        </div>
                        <div class="tab-pane fade" id="contactIcon" role="tabpanel" aria-labelledby="contact-icon-tab">Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore.</div>
                    </div>

                </div>
            </div>

            <!-- end of main-content -->
        </div>
        <x-layout.footer/>
    </div>
@endsection

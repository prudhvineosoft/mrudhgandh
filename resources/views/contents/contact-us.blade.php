@extends('layouts.master')

@section('content')

<!-- Page Header Start -->
<div class="container-fluid bg-secondary">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 100px">
        <h1 class="font-weight-semi-bold text-uppercase">Contact US</h1>
    </div>
</div>

<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Contact For Any Queries</span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col-lg-7 mb-5">
            <div class="contact-form">
                <div id="success"></div>
                <form name="sentMessage" id="contactForm" novalidate="novalidate">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <div class="control-group">
                        <input type="text" class="form-control" id="name" placeholder="Your Name"
                            required="required" data-validation-required-message="Please enter your name" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="email" class="form-control" id="email" placeholder="Your Email"
                            required="required" data-validation-required-message="Please enter your email" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="text" class="form-control" id="subject" placeholder="Subject"
                            required="required" data-validation-required-message="Please enter a subject" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <textarea class="form-control" rows="6" id="message" placeholder="Message"
                            required="required"
                            data-validation-required-message="Please enter your message"></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                    <div>
                        <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">Send
                            Message</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-5 mb-5">
            <h5 class="font-weight-semi-bold mb-3">Get In Touch</h5>
            <p>If you have any queries please send the message. We will connect with you soon.</p>
            <div class="d-flex flex-column mb-3">
                <h5 class="font-weight-semi-bold mb-3">Store</h5>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Union Bank, Ground floor, matalwadi phata, Bhugaon pune -51</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>mrudgandhmudpottery@gmail.com</p>
                <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>+91 9175904464</p>
            </div>
        </div>
    </div>
</div>
@endsection
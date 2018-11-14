@extends('layouts.master')
@section('title')
    Support
@endsection

@section('content')
<div class="container">
    <div class="box">
        <h1 class="title">Contact Us and Frequently Asked Questions</h1>
    </div>
    <br>
    <div class="columns">
        <div class="column">
            <h1 class="title is-4"><i>Contact Us</i></h1>
            <div class="box">
                {!! Form::open(['HomeController@submitSupportTicket']) !!}
                    <div class="field">
                        <label class="label">Name *</label>
                        <div class="control">
                            {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'input']) !!}
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Email *</label>
                        <div class="control">
                            {!! Form::email('email', null, ['placeholder' => 'Email', 'class' => 'input']) !!}
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Inquiry Reason *</label>
                        <div class="select">
                            {!! Form::select('reason', [
                                1 => 'General Questions',
                                2 => 'Billing',
                                3 => 'Plans',
                                4 => 'Bug or Another Online Issue',
                                5 => 'Other'
                            ], null, ['placeholder' => 'Select One', 'class' => 'select']) !!}
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Message *</label>
                        <div class="control">
                            {!! Form::textarea('msg', null, ['class' => 'textarea']) !!}
                        </div>
                    </div>
                    <button class="button is-primary" type="submit">Send</button>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="column">
            <h1 class="title is-4"><i>Frequently Asked Questions (FAQs)</i></h1>
            <p><b>Question:</b> How do I choose a plan and get started?</p>
            <p style="padding-left:50px"><b>Answer:</b> Review all of the plans on the <a href="/">homepage</a> and the click on "Join Now" to get started! If you have any questions on selecting a plan, please feel free to contact us.</p>
            <br>
            <p><b>Question:</b> Am I able to change or cancel my plan anytime?</p>
            <p style="padding-left:50px"><b>Answer:</b> Yes! Plans can be upgraded and cancelled up to twice per month. Caution should be taken when changing plans though because all changes take effect immediately and the new charge begins within 24 hours. If you have any questions or issues changing plans, please feel free to contact us.</p>
            <br>
            <p><b>Question:</b> How do I get into contact with you?</p>
            <p style="padding-left:50px"><b>Answer:</b> 2 options: use the form to the left or email us at <a href="info@team-stringer.com">info@team-stringer.com</a>. Either form will work and we will get back to you as soon as possible!</p>
            <br
            <p><b>Question:</b> How are payments processed and billing done?</p>
            <p style="padding-left:50px"><b>Answer:</b> All payments are processed through PayPal and the billing is taken care of by PayPal. You should NEVER enter any credit card information if prompted while on our domain or provide that information to anyone over email. If you have either of these occur, please contact us with more details.</p>
            <br>
            <p><i>Still have a question? Contact us now and we will get back to you as soon as possible!</i></p>
        </div>
    </div>
</div>
@endsection

<?php

use AwStudio\Maillog\Models\DatabaseLogRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
beforeEach(function () {
    File::put(storage_path('logs/maillog.log'), '');
});

test('It creates a log record when message sent event is fired', function () {
    Mail::raw('Hello world', function (Message $message) {
        $message->to('you@gmail.com')->from('me@gmail.com')->subject('Hello world');
    });

    ($content = File::get(storage_path('logs/maillog.log')));
    expect($content)->toContain('"type":"sent"');
    expect($content)->toContain('"to":"you@gmail.com"');
    expect($content)->toContain('"subject":"Hello world"');
});

test('It creates a log record  when message sending event is fired', function () {
    config(['maillog.logs' => ['sending']]);

    Mail::raw('Hello world', function (Message $message) {
        $message->to('you@gmail.com')->from('me@gmail.com')->subject('Hello world');
    });

    ($content = File::get(storage_path('logs/maillog.log')));
    expect($content)->toContain('"type":"sending"');
    expect($content)->toContain('"to":"you@gmail.com"');
    expect($content)->toContain('"subject":"Hello world"');
});

test('It doesnt create a database log records by default', function () {

    Mail::raw('Hello world', function (Message $message) {
        $message->to('you@gmail.com')->from('me@gmail.com')->subject('Hello world');
    });

    expect(DatabaseLogRecord::count())->toBe(0);
});

test('It creates a database log records when maillog channel database is enabled', function () {
    config(['maillog.channels' => ['database']]);

    Mail::raw('Hello world', function (Message $message) {
        $message->to('you@gmail.com')->from('me@gmail.com')->subject('Hello world');
    });

    expect(DatabaseLogRecord::first()->type)->toBe('sent');
    expect(DatabaseLogRecord::first()->to)->toBe('you@gmail.com');
    expect(DatabaseLogRecord::first()->subject)->toBe('Hello world');
});

<?php
namespace BMamba\Support;

function modify_request($request) {
//    $request = clone $request;

    $request->withAddedHeader('callback', $request->callback);
    $request->withAddedHeader('meta', $request->meta);

    return $request;
}

function modify_response($response) {

    $response = clone $response;

}
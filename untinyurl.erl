-module(untinyurl).

-export([untinyurl/1]).

untinyurl(TinyUrl) ->
    case http:request(head, {TinyUrl, []}, [{autoredirect, false}], []) of
        {ok, {_Status, Headers, _Body}} ->
            proplists:get_value("location", Headers, TinyUrl);
        _ ->
            TinyUrl
    end.

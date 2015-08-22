;var ls = ls || {};

if (ls.widgets) {
    ls.widgets.options.type.stream_comment_sandbox = {
        url: ls.routerUrl('ajax') + 'stream/comment_sandbox/'
    };
    ls.widgets.options.type.stream_topic_sandbox = {
        url: ls.routerUrl('ajax') + 'stream/topic_sandbox/'
    };
}

// EOF
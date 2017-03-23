<?php

namespace Gravure\Verification\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Gravure\Verification\Token;
use Illuminate\Routing\Controller;

class CallbackController extends Controller
{
    /**
     * Whenever a verification token callback hits the application.
     *
     * @param Token $token
     * @return RedirectResponse|Response
     */
    public function handle(Token $token)
    {
        if (! $token->exists) {
            throw new ModelNotFoundException(Token::class);
        }

        if (! $token->send_at) {
            abort(403, "Token wasn't send yet.");
        }

        if ($token->expires_at->isPast()) {
            $token->delete();

            abort(403, "Token expired.");
        }

        try {
            $response = $token->getCallback();
        } finally {
            $token->delete();
        }

        if ($response instanceof Response) {
            return $response;
        }

        return new RedirectResponse('/');
    }
}

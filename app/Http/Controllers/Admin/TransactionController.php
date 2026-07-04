public function payment($order_id)
{
    $categories =
        \App\Models\Category::all();

    $transaction =
        Transaction::with('event')
        ->where(
            'order_id',
            $order_id
        )
        ->firstOrFail();

    return view(
        'checkout.payment',
        compact(
            'transaction',
            'categories'
        )
    );
}
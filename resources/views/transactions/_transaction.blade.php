 <div class="{{ $loop->last ? '' : 'border-b border-gray-700' }} px-4 py-4 space-y-2">
        <div class="space-y-2">
            <div class="flex justify-between items-center">
                <div class="flex space-x-3">
                    <span class="text-{{ $transaction->isIncoming() ? 'green' : 'red' }}-500">
                        {{ $transaction->amount }}
                    </span>
                    <span>
                        {{ ($transaction->isIncoming() ? 'from' : 'to') . ' ' . ($transaction->partner ? $transaction->partner->name : '(Wallet Deleted)') }}
                    </span>
                </div>
                @if($transaction->fraudulent)
                    <div class="text-sm text-red-500">
                        [Marked as Fraudulent]
                    </div>
                @endif
            </div>

            <div class="flex justify-between text-sm">
                <div>

                    <form action="{{ route('wallets.transactions.update', [
                                        'wallet' => $wallet,
                                        'transaction' => $transaction
                                        ]) }}" method="POST">
                        @method('PATCH')
                        @csrf

                        <button
                            type="submit"
                            class="hover:underline"
                        >
                            {{ $transaction->fraudulent ? 'Not a Fraud' : 'Mark as Fraudulent'}}
                        </button>
                    </form>
                </div>
                <div>
                    <form action="{{ route('wallets.transactions.destroy', [
                                        'wallet' => $wallet,
                                        'transaction' => $transaction
                                        ]) }}" method="POST">
                        @method('DELETE')
                        @csrf

                        <button
                            type="submit"
                            class="hover:underline"
                        >
                            Delete this transaction
                        </button>
                    </form>
                </div>
            </div>
        </div>
 </div>

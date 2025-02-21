<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardsController extends Controller
{
  public function index(){
    $cards = Card::active()->orderByDesc('created_at')->get();
    return view('homecontent.masterdata.cards.index',compact('cards'));
  }
  public function create()
  {
      return view('homecontent.masterdata.cards.create');
  }

  public function store(Request $request)
  {
      $request->validate([
          'card_name' => 'required|string|max:255',
          'card_number' => 'required|string|max:255',
          'expiry_date' => 'required|string|max:255',
          'description' => 'nullable|string|max:255',
      ]);

      Card::create([
          'card_name' => $request->card_name,
          'card_number' => $request->card_number,
          'expiry_date' => $request->expiry_date,
          'description' => $request->description,
          'added_by' => auth()->id()
      ]);

      return redirect()->route('cards.index')->with('success', 'Card added successfully.');
  }

  public function edit(Card $card)
  {
    // dd($card);
      return view('homecontent.masterdata.cards.edit', compact('card'));
  }

  public function update(Request $request, Card $card)
  {

      $request->validate([
        'card_name' => 'required|string|max:255',
        'card_number' => 'required|string|max:255',
        'expiry_date' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
      ]);

      $card->update([
          'card_name' => $request->card_name,
          'card_number' => $request->card_number,
          'expiry_date' => $request->expiry_date,
          'description' => $request->description,
          'updated_by' => auth()->id()
      ]);

      return redirect()->route('cards.index')->with('success', 'Card updated successfully.');
  }

  public function destroy(Card $card)
  {
      $card->softDelete();
      return redirect()->route('cards.index')->with('success', 'Card deleted successfully.');
  }

}

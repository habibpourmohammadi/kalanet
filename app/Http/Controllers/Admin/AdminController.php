<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Guarantee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        $brands = Brand::all();
        $guarantees = Guarantee::all();
        $orders = Order::all();
        $users = User::all();
        return view('admin.index', compact("products", "categories", "brands", "guarantees", "orders", "users"));
    }
}

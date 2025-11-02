<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(Customer::class, 'email', ignoreRecord: true),
                        
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(50),
                        
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ])
                            ->required()
                            ->default('active'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Address')
                    ->schema([
                        Forms\Components\Textarea::make('address')
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('city')
                            ->maxLength(100),
                        
                        Forms\Components\TextInput::make('state')
                            ->maxLength(100),
                        
                        Forms\Components\TextInput::make('zip_code')
                            ->maxLength(20),
                        
                        Forms\Components\TextInput::make('country')
                            ->maxLength(100),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Billing Address')
                    ->schema([
                        Forms\Components\TextInput::make('billing_name')
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('billing_address')
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('billing_city')
                            ->maxLength(100),
                        
                        Forms\Components\TextInput::make('billing_state')
                            ->maxLength(100),
                        
                        Forms\Components\TextInput::make('billing_zip_code')
                            ->maxLength(20),
                        
                        Forms\Components\TextInput::make('billing_country')
                            ->maxLength(100),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('Shipping Address')
                    ->schema([
                        Forms\Components\TextInput::make('shipping_name')
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('shipping_address')
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('shipping_city')
                            ->maxLength(100),
                        
                        Forms\Components\TextInput::make('shipping_state')
                            ->maxLength(100),
                        
                        Forms\Components\TextInput::make('shipping_zip_code')
                            ->maxLength(20),
                        
                        Forms\Components\TextInput::make('shipping_country')
                            ->maxLength(100),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ]),
                
                Tables\Columns\TextColumn::make('orders_count')
                    ->counts('orders')
                    ->label('Orders')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}


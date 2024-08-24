<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExamResource\Pages;
use App\Filament\Resources\ExamResource\RelationManagers;
use Filament\Forms\Components\Actions\Action;
use App\Models\Exam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExamResource extends Resource
{
    protected static ?string $model = Exam::class;

    protected static ?string $navigationLabel = 'Examination';
    protected static ?string $navigationIcon = 'heroicon-s-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('time_limit')
                    ->label('Time Limit(In Seconds)')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),
                Forms\Components\Select::make('questions')
                    ->relationship('questions', 'question')
                    ->multiple()
                    ->searchable()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\Textarea::make('question')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull()
                            ->maxLength(255),
                        Forms\Components\Select::make('options')
                            ->relationship('options', 'option')
                            ->multiple()
                            ->searchable()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('option')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                            ])
                            ->createOptionAction(function (Action $action) {
                                return $action
                                    ->modalHeading('Create option')
                                    ->modalSubmitActionLabel('Create option')
                                    ->modalWidth('lg');
                            }),
                    Forms\Components\Select::make('correct_option_id')
                        ->relationship('correctOption', 'option')
                        ->label('Correct Answer')
                        ->searchable()
                        ->required(),
                    ])
                    ->createOptionAction(function (Action $action) {
                        return $action
                            ->modalHeading('Create question')
                            ->modalSubmitActionLabel('Create question')
                            ->modalWidth('lg');
                    })->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Faculty')
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('questions_count')
                    ->label('No. of Questions')
                    ->counts('questions'),
                Tables\Columns\TextColumn::make('time_limit')
                    ->label('Time Limit(In Seconds)')
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListExams::route('/'),
            'create' => Pages\CreateExam::route('/create'),
            'edit' => Pages\EditExam::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

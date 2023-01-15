import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { RecipeRoutingModule } from './recipe-routing.module';

import { RecipesComponent } from './components/recipes/recipes.component';
import { RecipeComponent } from './components/recipe/recipe.component';
import { SharedModule } from 'src/app/shared/shared.module';
import { NewRecipeComponent } from './components/new-recipe/new-recipe.component';


@NgModule({
  declarations: [
    RecipesComponent,
    RecipeComponent,
    NewRecipeComponent,
  ],
  imports: [
    CommonModule,
    SharedModule,

    RecipeRoutingModule
  ]
})
export class RecipeModule { }

import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { RecipeRoutingModule } from './recipe-routing.module';

import { RecipesComponent } from './components/recipes/recipes.component';
import { RecipeComponent } from './components/recipe/recipe.component';
import { SharedModule } from 'src/app/shared/shared.module';
import { NewRecipeComponent } from './components/new-recipe/new-recipe.component';
import { ReactiveFormsModule } from '@angular/forms';
import { MdbFormsModule } from 'mdb-angular-ui-kit/forms';

@NgModule({
  declarations: [
    RecipesComponent,
    RecipeComponent,
    NewRecipeComponent,
  ],
  imports: [
    CommonModule,
    SharedModule,
    ReactiveFormsModule,

    MdbFormsModule,

    RecipeRoutingModule
  ]
})
export class RecipeModule { }

import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { MainNavComponent } from './shared/main-nav/main-nav.component';
import { HeaderNavComponent } from './shared/header-nav/header-nav.component';
import { RegisterComponent } from './register/register.component';
import { LoginComponent } from './login/login.component';
import { RecipesComponent } from './recipes/recipes.component';
import { RecipeComponent } from './recipe/recipe.component';
import { IngredientsComponent } from './ingredients/ingredients.component';
import { IngredientComponent } from './ingredient/ingredient.component';
import { ShoplistComponent } from './shoplist/shoplist.component';
import { CalendarComponent } from './calendar/calendar.component';
import { PlanningComponent } from './planning/planning.component';
import { ProfileComponent } from './profile/profile.component';
import { ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';

@NgModule({
  declarations: [
    AppComponent,
    MainNavComponent,
    HeaderNavComponent,
    RegisterComponent,
    LoginComponent,
    RecipesComponent,
    RecipeComponent,
    IngredientsComponent,
    IngredientComponent,
    ShoplistComponent,
    CalendarComponent,
    PlanningComponent,
    ProfileComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    ReactiveFormsModule,
    HttpClientModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }

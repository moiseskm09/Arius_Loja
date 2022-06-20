function checkEMAIL(e)
{
  // verifica se o e-mail tem algum caracter especial
  ok = "1234567890qwertyuiop[]asdfghjklzxcvbnm.@-_QWERTYUIOPASDFGHJKLZXCVBNM";
  for(i=0; i < e.length ;i++)
  {
    if(ok.indexOf(e.charAt(i))<0)
    {
      return (false);
    }
  }
  // valida o formato do e-mail
  return (e.length == 0) || (e.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1);
}

function chkMaskEMAIL()
{
  return true;
}
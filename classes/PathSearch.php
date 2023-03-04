<?php
class PathSearch
{
    public array $matrix;
    public int $inf = PHP_INT_MAX;
    public Point $from, $to;
    function __construct($matrix, $from, $to)
    {
        $this->matrix = $matrix;
        $this->from = $from;
        $this->to = $to;
    }

    function getShortestPath()
    {
        // точки, по которым можно пройти
        $pointsToGo = array();
        //массив меток кратчайших расстояний
        $d = array();
        //массив пройденных точек
        $final = array();
        //ширина и высота поля
        $countX = count($this->matrix);
        $countY = count($this->matrix[0]);

        //проходим по всему полю
        for ($i = 1; $i < $countX; $i++)
        {
            for ($j = 1; $j < $countY; $j++)
            {
                if ($this->matrix[$i][$j] > 0)
                {
                    $d[$i][$j] = $this->inf; //заполняем массив меток "бесконечностями"
                    $pointsToGo[$i][$j] = $this->matrix[$i][$j]; // получаем все точки, по которым можно пройти
                }
            }
        }
        // метка начальной точки
        $d[$this->from->x][$this->from->y] = $this->matrix[$this->from->x][$this->from->y];
        // текущая точка
        $y = $this->from;
        // заносим текущую точку в пройденные
        $final[] = $y;

        while (!empty($y))
        {
            $neighbors = $this->getLinks($y, $pointsToGo);
            if (!empty($neighbors))
            {
                $this->UpdateDestinations($d, $pointsToGo, $neighbors, $y, $final);
                $y = $this->getMin($d, $y); // получаем следующую текущую точку
                if (!empty($y)) $final[] = $y; // если такая есть, добавляем в рассмотренные
            }
        }

    }

    function getLinks($y, $pointsToGo) : array
    {
        $neighbors = array();
        if (array_key_exists($y->x-1, $pointsToGo)) // проверка, существует ли точка
            $neighbors[] = new Point($y->x-1, $y->y);
        if (array_key_exists($y->x+1, $pointsToGo))
            $neighbors[] = new Point($y->x+1, $y->y);
        if (array_key_exists($y->y-1, $pointsToGo[$y->x]))
            $neighbors[] = new Point($y->x, $y->y-1);
        if (array_key_exists($y->y+1, $pointsToGo[$y->x]))
            $neighbors[] = new Point($y->x, $y->y+1);
        return $neighbors;
    }

    function UpdateDestinations(&$d, $pointsToGo, $neighbors, $y, $final)
    {
        foreach ($neighbors as $neighbor) // сохраняем минимальные значения расстояния до точек, соседних с текущей
        {
            if (!in_array($neighbor, $final)) // если точка не пройдена
            {
                $temp = $d[$y->x][$y->y]+$pointsToGo[$neighbor->x][$neighbor->y];
                if ($temp < $d[$neighbor->x][$neighbor->y]) $d[$neighbor->x][$neighbor->y] = $temp;
            }
        }
    }
    function getMin($d, $final)
    {
        $minKey = null;
        $minValue = max($d);
        foreach($d as $keyX => $valueX)
        {
            foreach($valueX as $keyY => $valueY)
            {
                if (($minValue > $valueY) && (!in_array(new Point($valueX, $valueY), $final)))
                {
                    $minValue = $valueY;
                    $minKey = new Point($keyX, $keyY);
                }
            }
        }
        return $minKey;
    }
}
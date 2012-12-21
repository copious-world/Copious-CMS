-- The Message class that represents messages inside a mailbox.

Message = {}

Message._mt = {}
setmetatable(Message, Message._mt)


Message._mt.__call = function (self, uid)
    local object = {}

    for key, value in pairs(Message) do
        if (type(value) == 'function') then
            object[key] = value
        end
    end

    object._mt = {}
    setmetatable(object, object._mt)

    object._uid = uid
    object._header = nil
    object._body = nil
    object._fields = {}

    return object
end


function Message.set_header(self, header)
    self._header = header
end

function Message.set_body(self, body)
    self._body = body
end

function Message.set_field(self, field, content)
    self._fields[field] = content
end


function Message.get_header(self)
    return self._header
end

function Message.get_body(self)
    return self._body
end

function Message.get_field(self, field)
    return self._fields[field]
end


function Message.cached_header(self)
    if (self._header == nil) then
        return false
    else
        return true
    end
end

function Message.cached_body(self)
    if (self._body == nil) then
        return false
    else
        return true
    end
end

function Message.cached_field(self, field)
    if (self._fields[field] == nil) then
        return false
    else
        return true
    end
end


Message._mt.__index = function () end
Message._mt.__newindex = function () end
